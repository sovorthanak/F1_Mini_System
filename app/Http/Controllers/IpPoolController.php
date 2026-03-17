<?php

namespace App\Http\Controllers;

use App\Models\IpPool;
use App\Models\IpInventory;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class IpPoolController extends Controller
{
    public function index(){
        $pools = IpPool::all();

        return view('administration.Ip_pool.index', compact('pools'));

    }

    /**
     * API: Return all active pools (for request-change IP dropdowns).
     */
    public function getPoolsJson()
    {
        $pools = IpPool::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'cidr']);

        return response()->json($pools);
    }

    /**
     * API: Return free IPs in a given pool (for request-change IP dropdowns).
     */
    public function getFreeIpsJson(IpPool $pool)
    {
        $ips = IpInventory::where('ip_pool_id', $pool->id)
            ->where('status', 'free')
            ->orderBy('ip_address')
            ->get(['id', 'ip_address']);

        return response()->json($ips);
    }
    public function viewCreate(){
        return view('administration.Ip_pool.create');
    }


    public function create(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:80',
            'cidr'        => 'required|string|max:32|unique:ip_pools,cidr',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'required|boolean',
        ]);

        try {
            $result = DB::transaction(function () use ($request) {

                // 1) Create Pool
                $ipPool = IpPool::create([
                    'name'        => $request->name,
                    'cidr'        => $request->cidr,
                    'description' => $request->description,
                    'is_active'   => $request->is_active,
                ]);

                // 2) Convert CIDR -> usable range
                [$startLong, $endLong] = $this->cidrToUsableLongRange($request->cidr);

                // 3) Bulk insert inventory rows (chunked)
                $chunkSize = 1000;
                $now = now();

                $buffer = [];
                $generated = 0;

                for ($long = $startLong; $long <= $endLong; $long++) {
                    $buffer[] = [
                        'ip_pool_id'  => $ipPool->id,
                        'ip_address'  => $this->longToIp($long),
                        'customer_id' => null,
                        'status'      => 'free',

                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ];

                    if (count($buffer) >= $chunkSize) {
                        IpInventory::insert($buffer);
                        $generated += count($buffer);
                        $buffer = [];
                    }
                }

                if (!empty($buffer)) {
                    IpInventory::insert($buffer);
                    $generated += count($buffer);
                }

                return [
                    'ipPool'     => $ipPool->fresh(),
                    'generated'  => $generated,
                ];
            });

            return redirect()
                ->route('ip.pools.index')
                ->with('success', (
                    'IP Pool added successfully.'
                ));

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Returns [startLong, endLong] for usable hosts (exclude network+broadcast).
     * Supports /8 to /30.
     */
    private function cidrToUsableLongRange(string $cidr): array
    {
        if (!preg_match('/^(\d{1,3}\.){3}\d{1,3}\/\d{1,2}$/', $cidr)) {
            throw new \InvalidArgumentException("Invalid CIDR format. Example: 10.175.6.0/24");
        }

        [$ip, $prefix] = explode('/', $cidr);
        $prefix = (int)$prefix;

        if ($prefix < 8 || $prefix > 30) {
            throw new \InvalidArgumentException("CIDR prefix must be between /8 and /30.");
        }

        $ipLong = ip2long($ip);
        if ($ipLong === false) {
            throw new \InvalidArgumentException("Invalid IP part in CIDR.");
        }

        // Unsigned
        $ipLong = (int) sprintf('%u', $ipLong);

        $mask = (int) sprintf('%u', ((~0 << (32 - $prefix)) & 0xFFFFFFFF));
        $network   = $ipLong & $mask;
        $broadcast = $network | (~$mask & 0xFFFFFFFF);


       return [$network, $broadcast];
    }

    /**
     * Convert unsigned long to IP safely (works even when > 2^31-1).
     */
    private function longToIp(int $long): string
    {
        // long2ip expects signed on some systems
        if ($long > 2147483647) {
            $long = $long - 4294967296;
        }

        $ip = long2ip($long);
        if ($ip === false) {
            throw new \RuntimeException("Failed converting long to IP.");
        }

        return $ip;
    }


    public function showIpInventory($poolId){

        $query = IpInventory::where('ip_pool_id', $poolId)->get();

        return view('administration.Ip_pool.show-ip-inventory', ['inventory' => $query]);
        
    }

    public function edit(IpPool $ipPool) {
        $ipPool->load("inventory");

        $begin_ip = $ipPool->inventory
            ->sortBy(fn ($i) => ip2long($i->ip_address))
            ->first()
            ->ip_address;

        $end_ip = $ipPool->inventory
            ->sortByDesc(fn ($i) => ip2long($i->ip_address))
            ->first()
            ->ip_address;

        $count_ip = $ipPool->inventory()->count();

        return view('administration.Ip_pool.edit',compact('ipPool', 'begin_ip', 'end_ip', 'count_ip'));
    }

    public function update(Request $request, IpPool $ipPool)
    {
        $request->validate([
            'name'        => 'required|string|max:80',
            'cidr'        => 'required|string|max:32|unique:ip_pools,cidr,' . $ipPool->id,
            'description' => 'nullable|string|max:255',
            'is_active'   => 'required|boolean',
        ]);

        try {
            $result = DB::transaction(function () use ($request, $ipPool) {

                $oldCidr = $ipPool->cidr;
                $newCidr = $request->cidr;

                // 1) Update pool fields
                $ipPool->update([
                    'name'        => $request->name,
                    'cidr'        => $newCidr,
                    'description' => $request->description,
                    'is_active'   => $request->is_active,
                ]);

                // If CIDR didn't change, don't touch inventory
                if ($oldCidr === $newCidr) {
                    return [
                        'ipPool'    => $ipPool->fresh(),
                        'added'     => 0,
                        'removed'   => 0,
                        'kept'      => $ipPool->inventory()->count(),
                        'note'      => 'CIDR unchanged (inventory not regenerated).',
                    ];
                }

                // 2) Build NEW usable set (as longs)
                [$newStart, $newEnd] = $this->cidrToUsableLongRange($newCidr);

                // 3) Fetch existing inventory (as map: ip_long => row info)
                // If you don't have ip_long column, see note below.
                $existing = $ipPool->inventory()
                    ->select('id', 'ip_address', 'status', 'customer_id')
                    ->get()
                    ->mapWithKeys(function ($row) {
                        $long = (int) sprintf('%u', ip2long($row->ip_address));
                        return [$long => $row];
                    });

                $now = now();
                $chunkSize = 1000;

                $toInsert = [];
                $added = 0;

                // 4) Insert missing IPs in the NEW range
                for ($long = $newStart; $long <= $newEnd; $long++) {
                    if ($existing->has($long)) continue;

                    $toInsert[] = [
                        'ip_pool_id'  => $ipPool->id,
                        'ip_address'  => $this->longToIp($long),
                        'customer_id' => null,
                        'status'      => 'free',
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ];

                    if (count($toInsert) >= $chunkSize) {
                        IpInventory::insert($toInsert);
                        $added += count($toInsert);
                        $toInsert = [];
                    }
                }

                if (!empty($toInsert)) {
                    IpInventory::insert($toInsert);
                    $added += count($toInsert);
                }

                // 5) Remove IPs that are OUTSIDE the NEW range
                // Safety: do not delete assigned IPs (optional but recommended)
                $removed = 0;

                // Get longs that should be removed
                $removeIds = $existing
                    ->filter(function ($row, $long) use ($newStart, $newEnd) {
                        return ($long < $newStart || $long > $newEnd);
                    })
                    ->filter(function ($row) {
                        // ✅ keep assigned/reserved if you want extra safety
                        return $row->status === 'free'; // only delete free
                    })
                    ->pluck('id')
                    ->values();

                if ($removeIds->isNotEmpty()) {
                    // delete in chunks
                    $removeIds->chunk(1000)->each(function ($chunk) use (&$removed) {
                        $removed += IpInventory::whereIn('id', $chunk)->delete();
                    });
                }

                $kept = $ipPool->inventory()->count();

                return [
                    'ipPool'  => $ipPool->fresh(),
                    'added'   => $added,
                    'removed' => $removed,
                    'kept'    => $kept,
                    'note'    => 'CIDR changed: inventory synced (added missing, removed out-of-range free IPs).',
                ];
            });

            return redirect()
                ->route('ip.pools.index')
                ->with('success', (
                    'IP Pool updated successfully.'
                ));


        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }





}

