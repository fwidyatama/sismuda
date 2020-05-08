<?php

namespace App\Exports;

use App\Models\SparepartOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromView;
class OrderList implements FromView
{
    public function view(): View
    {
        return view('coordinator.sparepart.listorder', [
            'spareparts' =>  DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('spareparts', 'spareparts.id', '=', 'orders.sparepart_id')
            ->select('orders.*', 'users.name as user_name', 'spareparts.name as sparepart_name')
            ->orderByDesc('date')
            ->get()
        ]);
    }
}
