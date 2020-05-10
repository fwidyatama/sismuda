<?php

namespace App\Http\Controllers;

use App\Exports\OrderList;
use App\Mail\SparepartOrderMail;
use App\Mail\SparepartOrderRejectionMail;
use Auth;
use App\Models\SparepartOrder;
use App\Models\Sparepart;
use App\Models\Bus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;
use Maatwebsite\Excel\Facades\Excel;

class SparepartOrderController extends Controller
{

    public function __construct()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Tidak dapat terhubung dengan database.");
        }
    }

    public function showOrderForm()
    {
        $spareparts = Sparepart::all();
        $buses = Bus::all();
        return view('officer.mechanic.sparepartorder', ['spareparts' => $spareparts, 'buses' => $buses]);
    }

    public function showOrderList()
    {
        // $spareparts = SparepartOrder::paginate(15);
        $spareparts = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('spareparts', 'spareparts.id', '=', 'orders.sparepart_id')
            ->select('orders.*', 'users.name as user_name', 'spareparts.name as sparepart_name')
            ->orderByDesc('date')
            ->paginate(10);

        // dd($spareparts);
        return view('coordinator.sparepart.orderlist', ['spareparts' => $spareparts]);
    }

    public function detailOrder($id)
    {
        $sparepart = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('spareparts', 'spareparts.id', '=', 'orders.sparepart_id')
            ->select('orders.*', 'users.name as user_name', 'spareparts.name as sparepart_name')
            ->where('orders.id', 'like', $id)
            ->first();

        // dd($sparepart);


        return view('coordinator.sparepart.verifiyorder', ['sparepart' => $sparepart]);
    }

    public function verifyOrder(Request $request, $id)
    {
        $sparepart = SparepartOrder::findOrFail($id);

        if ($request->action == 'approve') {
            $sparepart->status = '1';
            $sparepart->save();
            return redirect()->route('order.showlist')->with('status', 'Berhasil memverifikasi pengajuan suku cadang');
        } else if ($request->action == 'reject') {
            $data = DB::table('orders')
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('spareparts', 'spareparts.id', '=', 'orders.sparepart_id')
                ->select('orders.*', 'users.email', 'users.name as user_name', 'spareparts.name as sparepart_name')
                ->where('orders.id', 'like', $id)
                ->first();
            $sparepart->status = '2';
            $sparepart->save();
            Mail::to($data->email)->send(new SparepartOrderRejectionMail());

            return redirect()->route('order.showlist')->with('status', 'Berhasil memverifikasi pengajuan suku cadang');
        }
    }


    public function order($hullCode, $sparepartId, $type, $quantity, $unitName)
    {
        $order = new SparepartOrder();
        $order->user_id = Auth::user()->id;
        $order->hull_code = $hullCode;
        $order->sparepart_id = $sparepartId;
        $order->type = $type;
        $order->date = Carbon::now();
        $order->quantity = $quantity;
        $order->unit_name = $unitName;
        $order->save();
    }


    public function storeOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'hull_code' => 'required',
            'type' => 'required',
            'quantity' => 'required',
            'unit_name' => 'required',
            'type' =>'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        } else {

            
            $spareparts = $request->sparepart;
            foreach ($spareparts as $key => $sparepart) {
                $hullCode = $request->hull_code;
                $sparepartId = $request->sparepart;
                $type = $request->type;
                $quantity = $request->quantity;
                $unitName = $request->unit_name;
                // dd($hullCode,$sparepartId[$key],$type, $quantity[$key], $unitName[$key]);
                $this->order($hullCode, $sparepartId[$key], $type, $quantity[$key], $unitName[$key]);
                
            }
            $coordinatorEmail = User::where('id_role', '=', '1')->get();
            Mail::to($coordinatorEmail[0]->email)->send(new SparepartOrderMail());
            return redirect()->back()->with('status', 'Berhasil menambah data sparepart');
        }
    }

    public function getSparepart(Request $request)
    {
        $keyword = $request->q;
        $sparepart = \App\Models\Sparepart::all();
        return $sparepart;
    }

    public function downloadList(){
        return Excel::download(new OrderList, 'Sparepart Order.xlsx');
    }

    public function acceptedOrder(){
        $spareparts = DB::table('orders')
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->join('spareparts', 'spareparts.id', '=', 'orders.sparepart_id')
        ->select('orders.*', 'users.name as user_name', 'spareparts.name as sparepart_name')
        ->where('orders.status','=','1')
        ->orderByDesc('date')
        ->paginate(10);

    // dd($spareparts);
        return view('officer.logistic.sparepart', ['spareparts' => $spareparts]);
    }
}
