<?php
namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\Invoice;
use App\Models\RequestChange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // 1) KPI METRICS
        // =========================
        $totalCustomers = Register::count();

        $totalRevenue = Invoice::where('payment_status', 'Paid')
            ->sum(DB::raw('internet_fee + installation_fee + (ip_fee * ip_quantity)'));

        $totalInvoices = Invoice::count();

        $unpaidInvoices = Invoice::where('payment_status', 'Unpaid')->count();

        $totalUnpaidAmount = Invoice::where('payment_status', 'Unpaid')
            ->sum('total_amount');


        // =========================
        // 2) NEW CUSTOMERS (LAST 30 DAYS)
        // =========================
        $newCustomers = Register::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();


        // =========================
        // 3) REQUEST CHANGE (LINE + DISTRIBUTION)
        // =========================
        $requestTypes = [
            'Upgrade',
            'Downgrade',
            'Deactivate',
            'Reactivate',
            'Termination',
            'Relocation',
            'Change Ip Address'
        ];

        // last 30 days date labels
        $dates = [];
        $currentDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        while ($currentDate <= $endDate) {
            $dates[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // daily counts by type
        $requestChangesRaw = RequestChange::selectRaw('DATE(date) as date, request_type, COUNT(*) as count')
            ->whereBetween('date', [Carbon::now()->subDays(30), Carbon::now()])
            ->whereIn('request_type', $requestTypes)
            ->groupBy('date', 'request_type')
            ->orderBy('date')
            ->get();

        $requestChanges = [];
        foreach ($requestTypes as $type) {
            $requestChanges[$type] = array_fill_keys($dates, 0);
        }
        foreach ($requestChangesRaw as $row) {
            $requestChanges[$row->request_type][$row->date] = (int) $row->count;
        }

        $colors = [
            ['border' => '#007bff', 'background' => 'rgba(0, 123, 255, 0.1)'],
            ['border' => '#dc3545', 'background' => 'rgba(220, 53, 69, 0.1)'],
            ['border' => '#ffc107', 'background' => 'rgba(255, 193, 7, 0.1)'],
            ['border' => '#28a745', 'background' => 'rgba(40, 167, 69, 0.1)'],
            ['border' => '#6f42c1', 'background' => 'rgba(111, 66, 193, 0.1)'],
            ['border' => '#fd7e14', 'background' => 'rgba(253, 126, 20, 0.1)'],
            ['border' => '#17a2b8', 'background' => 'rgba(23, 162, 184, 0.1)'],
        ];

        $requestChangeDatasets = [];
        foreach ($requestTypes as $index => $type) {
            $requestChangeDatasets[] = [
                'label' => $type,
                'data' => array_values($requestChanges[$type]),
                'borderColor' => $colors[$index]['border'],
                'backgroundColor' => $colors[$index]['background'],
                'fill' => true,
                'tension' => 0.4,
            ];
        }

        // distribution (all-time)
        $requestTypeTotals = RequestChange::select('request_type', DB::raw('COUNT(*) as total'))
            ->whereIn('request_type', $requestTypes)
            ->groupBy('request_type')
            ->pluck('total', 'request_type')
            ->toArray();

        // ensure every type exists
        foreach ($requestTypes as $type) {
            $requestTypeTotals[$type] = $requestTypeTotals[$type] ?? 0;
        }


        // =========================
        // 4) CUSTOMER STATUS DISTRIBUTION
        // =========================
        $statusDistribution = Register::select('status', DB::raw('COUNT(*) as count'))
            ->whereNotNull('status')
            ->where('status', '!=', '')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();


        // =========================
        // 5) MONTHLY REVENUE (LAST 6 MONTHS)
        // =========================
        $startDate = Carbon::now()->subMonths(5)->startOfMonth();
        $endDate   = Carbon::now()->endOfMonth();

        $monthlyRevenue = DB::table('invoices')
            ->selectRaw("DATE_FORMAT(payment_date, '%Y-%m') as month, COALESCE(SUM(total_amount), 0) as revenue")
            ->where('payment_status', 'Paid')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $allMonths = [];
        $cursor = $startDate->copy();
        while ($cursor <= $endDate) {
            $allMonths[$cursor->format('Y-m')] = 0;
            $cursor->addMonth();
        }

        foreach ($monthlyRevenue as $row) {
            $allMonths[$row->month] = (float) $row->revenue;
        }

        $revenueData = [];
        foreach ($allMonths as $month => $revenue) {
            $revenueData[] = [
                'month' => Carbon::createFromFormat('Y-m', $month)->format('F Y'),
                'revenue' => $revenue,
            ];
        }


        // =========================
        // 6) CUSTOMER COUNT BY LOCATION
        // =========================
        $customersByLocation = Register::select('province', DB::raw('COUNT(*) as count'))
            ->whereNotNull('province')
            ->where('province', '!=', '')
            ->groupBy('province')
            ->pluck('count', 'province')
            ->toArray();


        // =========================
        // 7) TARIFF COUNTS (TOP 10 + OTHERS)
        // =========================
        $tariffCountsAll = Register::select('tariff_name', DB::raw('COUNT(*) as count'))
            ->whereNotNull('tariff_name')
            ->where('tariff_name', '!=', '')
            ->groupBy('tariff_name')
            ->orderByDesc('count')
            ->pluck('count', 'tariff_name')
            ->toArray();

        $tariffCountsTop10 = array_slice($tariffCountsAll, 0, 10, true);

        $tariffCounts = $tariffCountsTop10;


        // =========================
        // 8) MAP POINTS (lat_long parsing)
        // =========================
        $parseDmsToDecimal = function (string $dms): ?float {
            $dms = trim($dms);
            $pattern = '/(\d+(?:\.\d+)?)\s*°\s*(\d+(?:\.\d+)?)\s*[\'’]\s*(\d+(?:\.\d+)?)\s*["”]?\s*([NSEW])/i';

            if (!preg_match($pattern, $dms, $m)) return null;

            $deg = (float) $m[1];
            $min = (float) $m[2];
            $sec = (float) $m[3];
            $dir = strtoupper($m[4]);

            $dec = $deg + ($min / 60) + ($sec / 3600);
            if ($dir === 'S' || $dir === 'W') $dec *= -1;

            return $dec;
        };

        $parseLatLong = function (string $latLong) use ($parseDmsToDecimal): array {
            $latLong = trim($latLong);

            // decimal "lat,lng"
            if (preg_match('/^-?\d+(?:\.\d+)?\s*,\s*-?\d+(?:\.\d+)?$/', $latLong)) {
                [$lat, $lng] = array_map('trim', explode(',', $latLong));
                return [(float)$lat, (float)$lng];
            }

            // DMS "....N ....E"
            $dmsMatches = [];
            preg_match_all('/\d+(?:\.\d+)?\s*°\s*\d+(?:\.\d+)?\s*[\'’]\s*\d+(?:\.\d+)?\s*["”]?\s*[NSEW]/i', $latLong, $dmsMatches);

            if (!empty($dmsMatches[0]) && count($dmsMatches[0]) >= 2) {
                $lat = $parseDmsToDecimal($dmsMatches[0][0]);
                $lng = $parseDmsToDecimal($dmsMatches[0][1]);
                return [$lat, $lng];
            }

            return [null, null];
        };

        $customerPoints = Register::select('customer_name', 'province', 'status', 'tariff_name', 'bandwidth', 'lat_long')
            ->whereNotNull('lat_long')
            ->where('lat_long', '!=', '')
            ->get()
            ->map(function ($row) use ($parseLatLong) {
                [$lat, $lng] = $parseLatLong($row->lat_long);

                // Cambodia rough bounds filter
                if (
                    $lat === null || $lng === null ||
                    $lat === 0.0 || $lng === 0.0 ||
                    $lat < 9 || $lat > 15.6 ||
                    $lng < 102 || $lng > 108.8
                ) {
                    return null;
                }

                return [
                    'customer_name' => $row->customer_name,
                    'province'      => $row->province,
                    'status'        => $row->status,
                    'tariff_name'   => $row->tariff_name,
                    'bandwidth'     => $row->bandwidth,
                    'lat'           => $lat,
                    'lng'           => $lng,
                ];
            })
            ->filter()
            ->values();


        return view('dashboard', compact(
            'totalCustomers',
            'totalRevenue',
            'totalInvoices',
            'unpaidInvoices',
            'totalUnpaidAmount',
            'revenueData',
            'newCustomers',
            'dates',
            'requestChangeDatasets',
            'requestTypeTotals',
            'statusDistribution',
            'tariffCounts',
            'customersByLocation',
            'customerPoints'
        ));
    }


    public function customersByLocation()
    {
        $totalCustomers  = Register::count();
        $activeCustomers = Register::where('status', 'active')->count();
        $totalLocations  = Register::distinct('province')->count('province');

        // Bar chart: customer count by province
        $customersByLocation = Register::select('province', DB::raw('COUNT(*) as count'))
            ->groupBy('province')
            ->orderByDesc('count')
            ->pluck('count', 'province')
            ->toArray();

        // Optional: send chart arrays directly (easier in JS)
        $locationLabels = array_keys($customersByLocation);
        $locationCounts = array_values($customersByLocation);

        return view('home.customers_by_location', compact(
            'customersByLocation',
            'locationLabels',
            'locationCounts',
            'totalCustomers',
            'activeCustomers',
            'totalLocations'
        ));
    }

}