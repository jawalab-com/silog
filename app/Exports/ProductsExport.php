<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductsExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    protected $from;

    protected $to;

    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return Product::leftJoin('inventories', 'products.id', '=', 'inventories.product_id')
            ->select(
                'products.product_name',
                'products.tag',
                'products.product_description',
                'products.minimum_quantity',
                \DB::raw('COALESCE(inventories.quantity, 0) as quantity'),
                \DB::raw('CASE WHEN products.verified = 1 THEN "Ya" ELSE "TIDAK" END as verified')
            )
            ->when($this->status == 'available', function ($query) {
                return $query->whereRaw('COALESCE(inventories.quantity, 0) > products.minimum_quantity');
            })
            ->when($this->status == 'less', function ($query) {
                return $query->whereRaw('COALESCE(inventories.quantity, 0) < products.minimum_quantity AND COALESCE(inventories.quantity, 0) > 0');
            })
            ->when($this->status == 'empty', function ($query) {
                return $query->whereRaw('COALESCE(inventories.quantity, 0) <= 0');
            })
            ->get();
    }

    public function headings(): array
    {
        // Definisikan nama kolom
        return [
            'NAMA BARANG',
            'KATEGORI',
            'SPESIFIKASI',
            'JUMLAH MINIMUM',
            'JUMLAH STOK',
            'TERVERIFIKASI',
        ];
    }
}
