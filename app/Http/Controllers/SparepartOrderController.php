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

    public function order(Request $request)
    {
        $hullCode = $request->hull_code;
        if ($hullCode != null) {
            $order = new SparepartOrder();
            $order->user_id = $request->user_id;
            $order->hull_code = $request->hull_code;
            $order->sparepart_id = $request->sparepart_id;
            $order->type = $request->type;
            $order->date = $request->date;
            $order->quantity = $request->quantity;
            $order->unit_name = $request->unit_name;
            $order->save();
            return response()->json(['True'],200);
        } else {
            return response()->json(['False'],500);
        }
    }

    public function storeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required'
        ],[
            'type.required' => 'field harus diisi',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Semua field harus diisi');
        } else {
            $hullCode = $request->hull_code;
            $spareparts = $request->sparepart;
            $type = $request->type;
            $quantity = $request->quantity;
            $unitName =  $request->unit_name;
            $request = new Request();

            foreach ($spareparts as $key => $sparepart) {
                $data = [
                    'user_id' => Auth::user()->id,
                    'hull_code' => $hullCode,
                    'sparepart_id' => $spareparts[$key],
                    'type' => $type,
                    'date' => Carbon::now(),
                    'quantity' => $quantity[$key],
                    'unit_name' => $unitName[$key],
                ];
                $request->merge($data);
                $this->order($request);
            }
            $coordinatorEmail = User::where('id_role', '=', '1')->get();
            Mail::to($coordinatorEmail[0]->email)->send(new SparepartOrderMail());
            return redirect()->back()->with('status', 'Berhasil menambah data sparepart');
        }
    }




    // public function storeOrder(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'hull_code' => 'required',
    //         'type' => 'required',
    //         'quantity' => 'required',
    //         'unit_name' => 'required',
    //         'type' =>'required'
    //     ]);
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)
    //             ->withInput();
    //     } else {
    //         $spareparts = $request->sparepart;
    //         foreach ($spareparts as $key => $sparepart) {
    //             $data = [
    //             'user_id' => Auth::user()->id,
    //             'hull_code' => $request->hull_code,
    //             'sparepart_id' =>$spareparts[$key],
    //             'type' => $request->type,
    //             'date' => Carbon::now(),
    //             'quantity' => $request->quantity[$key],
    //             'unit_name' => $request->unit_name[$key],
    //         ];
    //         // dd($data);
    //         // $dataOrder=$request->merge($data);
    //         $request = new Request($data);
    //         // $this->order($request);
    //             // $requestData = new Request($data);
    //             // dd($requestData->user_id);
    //             // $hullCode = $request->hull_code;
    //             // $sparepartId = $request->sparepart;
    //             // $type = $request->type;
    //             // $quantity = $request->quantity;
    //             // $unitName = $request->unit_name;
    //             // dd($dataOrder);

    //         }
    //         dd($request);
    //         $coordinatorEmail = User::where('id_role', '=', '1')->get();
    //         Mail::to($coordinatorEmail[0]->email)->send(new SparepartOrderMail());
    //         return redirect()->back()->with('status', 'Berhasil menambah data sparepart');
    //     }
    // }

    public function getSparepart(Request $request)
    {
        $keyword = $request->q;
        $sparepart = \App\Models\Sparepart::all();
        return $sparepart;
    }

    public function downloadList(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $monthTitle = '';

        switch ($month) {
            case "01":
                $monthTitle = 'Januari';
                break;
            case "02":
                $monthTitle = 'Februari';
                break;
            case "03":
                $monthTitle = 'Maret';
                break;
            case "04":
                $monthTitle = 'April';
                break;
            case "05":
                $monthTitle = 'Mei';
                break;
            case "06":
                $monthTitle = 'Juni';
                break;
            case "07":
                $monthTitle = 'Juli';
                break;
            case "08":
                $monthTitle = 'Agustus';
                break;
            case "09":
                $monthTitle = 'September';
                break;
            case "10":
                $monthTitle = 'Oktober';
                break;
            case "11":
                $monthTitle = 'November';
                break;
            case "12":
                $monthTitle = 'Desember';
                break;
            default:
                break;
        }
        if ($request->action == 'download') {
        return Excel::download(new OrderList($month, $year), "Order_{$monthTitle}_${year}.xlsx");}

        $spareparts=DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('spareparts', 'spareparts.id', '=', 'orders.sparepart_id')
            ->select('orders.*', 'users.name as user_name', 'spareparts.name as sparepart_name')
            ->whereMonth('orders.date',$month)
            ->whereYear('orders.date',$year)
            ->orderByDesc('date')
            ->get();
            return view('coordinator.sparepart.orderlist', ['spareparts' => $spareparts]);
    }

    public function acceptedOrder()
    {
        $spareparts = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->join('spareparts', 'spareparts.id', '=', 'orders.sparepart_id')
            ->select('orders.*', 'users.name as user_name', 'spareparts.name as sparepart_name')
            ->where('orders.status', '=', '1')
            ->orderByDesc('date')
            ->paginate(10);
        return view('officer.logistic.sparepart', ['spareparts' => $spareparts]);
    }

}
