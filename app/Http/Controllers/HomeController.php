<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(Request $request)
    {
        $dbDriver = \DB::getDriverName();
        $department = $request->input('department', null);

        // PENGELUARAN ======================================================================
        if ($dbDriver === 'sqlite') {
            $yearField = \DB::raw("strftime('%Y', rfq_suppliers.updated_at) as year");
            $monthField = \DB::raw("strftime('%m', rfq_suppliers.updated_at) as month");
        } else { // Default to MySQL
            $yearField = \DB::raw('YEAR(rfq_suppliers.updated_at) as year');
            $monthField = \DB::raw('MONTH(rfq_suppliers.updated_at) as month');
        }
        $pengeluaran = \DB::table('rfq_suppliers')
            ->join('rfqs', 'rfqs.id', '=', 'rfq_suppliers.rfq_id')
            ->join('rfq_details', 'rfqs.id', '=', 'rfq_details.rfq_id')
            ->join('users', 'rfqs.user_id', '=', 'users.id')
            ->select(
                $yearField,
                $monthField,
                \DB::raw('SUM(CASE WHEN paid = 0 THEN total_price ELSE 0 END) as total_not_paid'),
                \DB::raw('SUM(CASE WHEN paid = 1 THEN total_price ELSE 0 END) as total_paid')
            )
            ->groupBy('year', 'month')
            ->when($department, function ($query, $department) {
                return $query->where('users.department', $department);
            })
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Generate the last 12 months
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push([
                'month' => now()->subMonths($i)->format('M y'),
                'total_not_paid' => 0,
                'total_paid' => 0,
            ]);
        }

        // Merge the data with the last 12 months
        $pengeluaranArray = $pengeluaran->toArray();
        $pengeluaran = $months->map(function ($month) use ($pengeluaranArray) {
            $data = null;
            foreach ($pengeluaranArray as $item) {
                if ($item->year == now()->parse($month['month'])->format('Y') && $item->month == now()->parse($month['month'])->format('m')) {
                    $data = $item;
                    break;
                }
            }

            return [
                'month' => $month['month'],
                'total_not_paid' => $data->total_not_paid ?? 0,
                'total_paid' => $data->total_paid ?? 0,
            ];
        });
        $pengeluaranPaid = $pengeluaran->pluck('total_paid')->toArray();
        $pengeluaranNotPaid = $pengeluaran->pluck('total_not_paid')->toArray();
        $pengeluaranLabels = $pengeluaran->pluck('month')->toArray();

        $pengeluaran = [
            'paid' => $pengeluaranPaid,
            'not_paid' => $pengeluaranNotPaid,
            'labels' => $pengeluaranLabels,
        ];
        // =================================================================================

        $kategori_pengeluaran_terbanyak = \DB::table('rfq_details')
            ->join('products', 'products.id', '=', 'rfq_details.product_id')
            ->join('tags', 'tags.slug', '=', 'products.tag')
            ->select('tags.tag_name as labels', \DB::raw('SUM(rfq_details.total_price) as series'))
            ->groupBy('tags.slug', 'tags.tag_name')
            ->orderByDesc('series')
            ->limit(5)
            ->get();
        $total_kategori_pengeluaran_terbanyak = $kategori_pengeluaran_terbanyak->sum('series');

        $supplier_terbanyak = \DB::table('rfq_suppliers')
            ->join('suppliers', 'rfq_suppliers.supplier_id', '=', 'suppliers.id')
            ->select('suppliers.supplier_name as labels', \DB::raw('COUNT(1) as series'))
            ->groupBy('suppliers.id', 'suppliers.supplier_name')
            ->orderByDesc('series')
            ->limit(5)
            ->get();
        $total_supplier_terbanyak = $supplier_terbanyak->sum('series');

        $brand_terbanyak = \DB::table('rfq_details')
            ->join('products', 'products.id', '=', 'rfq_details.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select('brands.brand_name as labels', \DB::raw('COUNT(1) as series'))
            ->groupBy('brands.id', 'brands.brand_name')
            ->orderByDesc('series')
            ->limit(5)
            ->get();
        $total_brand_terbanyak = $brand_terbanyak->sum('series');

        $stok_keluar_terbanyak = \DB::table('inventory_transactions')
            ->join('products', 'inventory_transactions.product_id', '=', 'products.id')
            ->select('products.product_name as x', \DB::raw('SUM(inventory_transactions.quantity_change) * -1 as y'))
            ->where('inventory_transactions.quantity_change', '<', 0)
            ->whereMonth('transaction_date', date('m'))
            ->groupBy('products.id', 'products.product_name')
            ->orderBy('y', 'desc')
            ->limit(5)
            ->get();

        $stok_keluar_terkecil = \DB::table('inventory_transactions')
            ->join('products', 'inventory_transactions.product_id', '=', 'products.id')
            ->select('products.product_name as x', \DB::raw('SUM(inventory_transactions.quantity_change) * -1 as y'))
            ->where('inventory_transactions.quantity_change', '<', 0)
            ->whereMonth('transaction_date', date('m'))
            ->groupBy('products.id', 'products.product_name')
            ->orderBy('y', 'asc')
            ->limit(5)
            ->get();

        $data = [
            'pengeluaran' => $pengeluaran,
            'sumHutang' => \DB::table('rfqs')
                ->join('rfq_details', 'rfqs.id', '=', 'rfq_details.rfq_id')
                ->where('status', 'sedang-dalam-pengiriman')
                ->sum('rfq_details.total_price'),
            'countBelumSelesai' => \DB::table('rfqs')->where('status', '!=', 'selesai')->count(),
            'countSelesai' => \DB::table('rfqs')->where('status', 'selesai')->count(),
            'countPengajuan' => \DB::table('rfqs')->whereMonth('request_date', date('m'))->count(),
            'kategori_pengeluaran_terbanyak' => [
                'labels' => $kategori_pengeluaran_terbanyak->pluck('labels')->toArray(),
                'series' => $kategori_pengeluaran_terbanyak->map(function ($item) use ($total_kategori_pengeluaran_terbanyak) {
                    return $total_kategori_pengeluaran_terbanyak > 0 ? round(($item->series / $total_kategori_pengeluaran_terbanyak) * 100, 2) : 0;
                })->toArray(),
            ],
            'supplier_terbanyak' => [
                'labels' => $supplier_terbanyak->pluck('labels')->toArray(),
                'series' => $supplier_terbanyak->map(function ($item) use ($total_supplier_terbanyak) {
                    return $total_supplier_terbanyak > 0 ? round(($item->series / $total_supplier_terbanyak) * 100, 2) : 0;
                })->toArray(),
            ],
            'brand_terbanyak' => [
                'labels' => $brand_terbanyak->pluck('labels')->toArray(),
                'series' => $brand_terbanyak->map(function ($item) use ($total_brand_terbanyak) {
                    return $total_brand_terbanyak > 0 ? round(($item->series / $total_brand_terbanyak) * 100, 2) : 0;
                })->toArray(),
            ],
            'stok_keluar_terbanyak' => $stok_keluar_terbanyak,
            'stok_keluar_terkecil' => $stok_keluar_terkecil,
            'department' => $department,
        ];

        return Inertia::render('Dashboard', $data);
    }
}
