<?php

namespace App\Exports;

use App\Models\Rfq;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Rfq::all();
    }
}
