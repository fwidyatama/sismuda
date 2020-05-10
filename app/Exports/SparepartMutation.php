<?php

namespace App\Exports;

use App\Models\Mutation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class SparepartMutation implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

  
    function __construct($month,$year)
    {
     $this->month = $month;   
     $this->year = $year;   
    }

    public function view(): View
    {
        return view('officer.logistic.listmutation', [
            'mutations' => DB::table('mutates')
            ->join('users', 'users.id', '=', 'mutates.user_id')
            ->join('spareparts', 'spareparts.id', '=', 'mutates.sparepart_id')
            ->select('mutates.*', 'users.name as user_name', 'spareparts.name as sparepart_name','spareparts.price as sparepart_price','spareparts.quantity as stock')
            ->whereMonth('mutates.date',$this->month)
            ->whereYear('mutates.date',$this->year)
            ->orderByDesc('date')
            ->get()
        ]);
    }
}
