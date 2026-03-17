<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RequestChange;
use Carbon\Carbon;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendPendingRequestNotification extends Command
{
    protected $signature = 'notify:pending-requests';
    protected $description = 'Send daily notification about pending requests';

    public function handle()
    {
        // ✅ Production: use Carbon::today()->toDateString()
        $today = Carbon::today()->toDateString();

        // 🔧 Testing sample:
        // $today = Carbon::create(2026, 1, 1)->toDateString();

        $pendingRequests = RequestChange::with('customer')
            ->where('status', 'Pending')
            ->whereDate('date', '<=', $today)
            ->orderBy('date')
            ->get();

        $groupChatId = env('NOC_GROUP_CHAT_ID');

        $parts = $this->buildMessageParts($pendingRequests);

        try {
            $this->sendTelegramInBlocks(
                $groupChatId,
                $parts['header'],
                $parts['blocks'],
                $parts['footer'],
                'Markdown'
            );

            $this->info('✓ Notification sent successfully!');
            $this->info('Total pending requests: ' . $pendingRequests->count());
        } catch (\Exception $e) {
            $this->error('✗ Failed to send notification: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Build header + request blocks + footer (blocks are atomic; never split inside a request)
     */
    private function buildMessageParts($requests): array
    {
        $header  = "📋 *PENDING REQUESTS - " . Carbon::today()->format('d M Y') . "*\n";
        $header .= "━━━━━━━━━━━━━━━━━━━━━━━\n\n";

        if ($requests->isEmpty()) {
            return [
                'header' => $header,
                'blocks' => ["✅ *No pending requests for today*\n"],
                'footer' => '',
            ];
        }

        $blocks = [];

        foreach ($requests as $index => $req) {
            $num = $index + 1;

            $customerName = $req->customer->customer_name
                ?? $req->old_customer_name
                ?? 'Unknown';

            $customerId = $req->customer->customer_id ?? 'N/A';
            $pppoe      = $req->customer->pppoe ?? 'N/A';

            $block  = "*{$num}. {$this->getRequestTypeWithIcon($req->request_type)}*\n";
            $block .= "     - Customer: *{$customerName}*\n";
            $block .= "     - ID: *{$customerId}*\n";
            $block .= "     - PPPOE: *{$pppoe}*\n";
            $block .= $this->getChangeDetails($req);
            $block .= "     - Created by: *{$req->created_by}*\n\n";

            $blocks[] = $block;
        }

        $footer  = "━━━━━━━━━━━━━━━━━━━━━━━\n";
        $footer .= "📊 *Total: {$requests->count()} request(s)*";

        return [
            'header' => $header,
            'blocks' => $blocks,
            'footer' => $footer,
        ];
    }

    /**
     * Send message in multiple Telegram messages without splitting any request block.
     * Telegram limit: 4096 characters.
     */
    private function sendTelegramInBlocks(
        string $chatId,
        string $header,
        array $blocks,
        string $footer = '',
        string $parseMode = 'Markdown'
    ): void {
        $max = 4096;

        $parts = [];
        $current = $header;

        foreach ($blocks as $block) {
            // Extremely rare case: a single request block is larger than Telegram limit
            if (mb_strlen($block, 'UTF-8') > $max) {
                // flush current first (if it has content beyond header)
                if (trim($current) !== trim($header)) {
                    $parts[] = trim($current);
                    $current = $header;
                }

                // hard split the large block (best effort)
                $safeMax = max(500, $max - mb_strlen($header, 'UTF-8') - 50);
                foreach ($this->hardSplit($block, $safeMax) as $piece) {
                    $parts[] = trim($header . $piece);
                }

                continue;
            }

            $candidate = $current . $block;

            if (mb_strlen($candidate, 'UTF-8') > $max) {
                // finalize current part, start new with header + entire block
                $parts[] = trim($current);
                $current = $header . $block;
            } else {
                $current = $candidate;
            }
        }

        // Attach footer to last message if possible, otherwise send it as a final part
        if ($footer !== '') {
            $candidate = rtrim($current) . "\n" . $footer;

            if (mb_strlen($candidate, 'UTF-8') <= $max) {
                $current = $candidate;
            } else {
                $parts[] = trim($current);
                $current = trim($header . $footer);
            }
        }

        $parts[] = trim($current);

        // Send parts with optional "Part x/y"
        $total = count($parts);

        foreach ($parts as $i => $text) {
            $prefix = '';
            if ($total > 1) {
                $prefix = "📨 *Part " . ($i + 1) . "/{$total}*\n\n";
            }

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $prefix . $text,
                'parse_mode' => $parseMode,
            ]);
        }
    }

    /**
     * Hard split UTF-8 safe (only used if one request block is abnormally huge)
     */
    private function hardSplit(string $text, int $maxLen): array
    {
        $parts = [];
        $len = mb_strlen($text, 'UTF-8');

        for ($i = 0; $i < $len; $i += $maxLen) {
            $parts[] = mb_substr($text, $i, $maxLen, 'UTF-8');
        }

        return $parts;
    }

    /**
     * Get request type with emoji icon
     */
    private function getRequestTypeWithIcon($requestType)
    {
        $icons = [
            'Upgrade' => '⬆️ Upgrade',
            'Downgrade' => '⬇️ Downgrade',
            'Change Service' => '🔄 Change Service',
            'Relocation' => '🚚 Relocation',
            'Add IP Address' => '➕ Add IP Address',
            'Change IP Address' => '🌐 Change IP Address',
            'Change Ip Address' => '🌐 Change IP Address',
            'Remove IP Address' => '➖ Remove IP Address',
            'Change Remark' => '📝 Change Remark',
            'Deactivate' => '⏸️ Deactivate',
            'Reactivate' => '▶️ Reactivate',
            'Termination' => '🛑 Termination',
        ];

        return $icons[$requestType] ?? $requestType;
    }

    /**
     * Get specific change details based on request type
     */
    private function getChangeDetails($request): string
    {
        $details = "";

        switch ($request->request_type) {
            case 'Upgrade':
            case 'Downgrade':
            case 'Change Service':
                if ($request->old_tariff && $request->new_tariff) {
                    $oldPlan = trim("{$request->old_tariff} {$request->old_bandwidth}");
                    $newPlan = trim("{$request->new_tariff} {$request->new_bandwidth}");
                    $details .= "     - Plan: *{$oldPlan} → {$newPlan}*\n";
                }
                break;

            case 'Relocation':
                if ($request->new_address) {
                    $details .= "     - New Address: *{$request->new_address}*\n";
                }
                if ($request->new_province) {
                    $details .= "     - New Province: *{$request->new_province}*\n";
                }
                break;

            case 'Add IP Address':
                if ($request->new_ip_address) {
                    $ips = $this->formatIpAddresses($request->new_ip_address);
                    $details .= "     - New IPs: {$ips}\n";
                }
                break;

            case 'Change IP Address':
            case 'Change Ip Address':
                if ($request->old_ip_address || $request->new_ip_address) {
                    $oldIps = $this->formatIpAddresses($request->old_ip_address);
                    $newIps = $this->formatIpAddresses($request->new_ip_address);
                    $details .= "     - IP: {$oldIps} → {$newIps}\n";
                }
                break;

            case 'Remove IP Address':
                if ($request->old_ip_address) {
                    $ips = $this->formatIpAddresses($request->old_ip_address);
                    $details .= "     - Removing IPs: {$ips}\n";
                }
                break;

            case 'Change Remark':
                if ($request->new_remark) {
                    $remark = mb_strlen($request->new_remark) > 50
                        ? mb_substr($request->new_remark, 0, 50) . '...'
                        : $request->new_remark;

                    $details .= "     - New Remark: *{$remark}*\n";
                }
                break;

            case 'Deactivate':
            case 'Reactivate':
            case 'Termination':
                if ($request->new_customer_status) {
                    $details .= "     - Status: *{$request->old_customer_status} → {$request->new_customer_status}*\n";
                }
                break;
        }

        return $details;
    }

    /**
     * Format IP addresses for display
     */
    private function formatIpAddresses($ipString): string
    {
        if (!$ipString || trim($ipString) === '') {
            return 'N/A';
        }

        $ips = array_map('trim', explode(',', $ipString));
        $ips = array_filter($ips);

        return implode(', ', $ips);
    }
}
