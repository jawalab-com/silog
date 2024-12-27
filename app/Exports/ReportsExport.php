<?php

namespace App\Exports;

use App\Models\Rfq;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    protected $from;

    protected $to;

    protected $status;

    public function __construct($from, $to, $status)
    {
        $this->from = $from;
        $this->to = $to;
        $this->status = $status;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Rfq::whereBetween('request_date', [$this->from, $this->to])
        //     ->where('status', $this->status)
        //     ->get();

        return Rfq::join('rfq_details', 'rfqs.id', '=', 'rfq_details.rfq_id')
            ->join('products', 'rfq_details.product_id', '=', 'products.id')
            ->join('units', 'rfq_details.unit_id', '=', 'units.id')
            ->join('users', 'rfqs.user_id', '=', 'users.id')
            ->select(
                'rfqs.rfq_number',
                'users.name',
                'rfqs.request_date',
                'rfqs.allocation_date',
                'rfqs.title',
                'products.product_name',
                'products.tag',
                'rfq_details.quantity',
                'units.unit_name',
                'rfq_details.estimation_price',
                'rfq_details.unit_price',
                'rfq_details.total_price',
                'rfqs.status'
            )
            ->whereBetween('rfqs.request_date', [$this->from, $this->to])
            ->when(! empty($this->status), function ($query) {
                return $query->where('rfqs.status', $this->status);
            })
            ->get();
    }

    public function headings(): array
    {
        // Definisikan nama kolom
        return [
            'NO PENGAJUAN',
            'PENGAJU',
            'TANGGAL PENGAJUAN',
            'TANGGAL DIGUNAKAN',
            'PERIHAL',
            'NAMA BARANG',
            'KATEGORI',
            'JUMLAH',
            'SATUAN',
            'HARGA ESTIMASI',
            'HARGA',
            'JUMLAH HARGA',
            'STATUS',
        ];
    }
}
