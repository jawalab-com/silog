<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $data = [
            'sumHutang' => \DB::table('rfqs')
                ->join('rfq_details', 'rfqs.id', '=', 'rfq_details.rfq_id')
                ->where('status', 'sedang-dalam-pengiriman')
                ->sum('rfq_details.total_price'),
            'countBelumSelesai' => \DB::table('rfqs')->where('status', '!=', 'selesai')->count(),
            'countSelesai' => \DB::table('rfqs')->where('status', 'selesai')->count(),
            'countPengajuan' => \DB::table('rfqs')->whereMonth('request_date', date('m'))->count(),
        ];

        return Inertia::render('Dashboard', $data);
    }
}
