<?php

namespace App\Exports;

use App\Models\SparepartOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromView;
class OrderList implements FromView
{
    function __construct($month,$year)
    {
     $this->month = $month;   
     $this->year = $year;   
    }

    public function view(): View
    {
        return view('coordinator.sparepart.listorder', [
            'spareparts' =>  DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('spareparts', 'spareparts.id', '=', 'orders.sparepart_id')
            ->select('orders.*', 'users.name as user_name', 'spareparts.name as sparepart_name')
            ->whereMonth('orders.date',$this->month)
            ->whereYear('orders.date',$this->year)
            ->orderByDesc('date')
            ->get()
        ]);
    }
}
