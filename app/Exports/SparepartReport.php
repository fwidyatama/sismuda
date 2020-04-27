<?php

namespace App\Exports;

use App\Models\Sparepart;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;


class SparepartReport implements FromView
{
    public function view(): View
    {
        return view('coordinator.sparepart.listsparepart', [
            'spareparts' => Sparepart::all()
        ]);
    }
}
