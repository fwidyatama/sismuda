<?php

namespace App\Http\Controllers;

use App\Mail\BusCheckMail;
use App\Models\BusCheck;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Support\Facades\DB;

class BusCheckingController extends Controller
{
    //
    public function showCheckingForm()
    {
        return view('officer.crew.buschecking');
    }

    public function storeOrder(Request $request)
    {
        $hullCode = $request->hull_code;
        if ($hullCode != null) {
            $check = new BusCheck();
            $check->user_id = $request->user_id;
            $check->hull_code = $request->hull_code;
            $check->complaint = $request->complaint;
            $check->date = $request->date;
            $check->save();
            return response()->json(['True'], 200);
        } else {
            return response()->json(['False'], 500);
        }
    }


    public function storeBusChecking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'complaint' => 'required',
        ],[
            'complaint.required'=> 'Field harus diisi'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Semua field harus diisi');
        } else {
            $user_id = Auth::user()->id;
            $hullCode = $request->hull_code;
            $complaint = $request->complaint;
            $date = Carbon::now();

            $request = new Request();
            $data = [
                'user_id' => $user_id,
                'hull_code' => $hullCode,
                'complaint' => $complaint,
                'date' => $date
            ];
            $request->merge($data);
            $this->storeOrder($request);
            $coordinatorEmail = User::where('id_role', '=', '1')->get();
            Mail::to($coordinatorEmail[0]->email)->send(new BusCheckMail());
            return redirect()->back()->with('status', 'Berhasil melakukan permintaan pengecekan');
        }
    }

    public function showBusCheck()
    {
        $checkOrders = BusCheck::with('user')->orderBy('date', 'DESC')->paginate(15);

        return view('coordinator.buscheck.dashboard', ['checkOrders' => $checkOrders]);
    }

    public function deleteOrder($id)
    {
        $checkOrder = BusCheck::findOrFail($id);
        $checkOrder->delete();
        return redirect()->back()->with('status', 'Berhasil menghapus riwayat pengecekan');
    }

    public function detailOrder($id)
    {
        $checkOrder = BusCheck::findOrFail($id);
        return view('coordinator.buscheck.detail', ['checkOrder' => $checkOrder]);
    }

    public function verifyOrder(Request $request)
    {
        $busCheck = new BusCheck();
        $checkOrder = $busCheck->getBusDetail($request->id);
        if ($request->action == 'approve') {
            $checkOrder['status'] = 2;
            $busCheck->status = $checkOrder['status'];
            DB::table('bus_checks')
            ->where('id',$checkOrder['id'])
            ->update(['status'=>$checkOrder['status']]);
            // return response()->json(['True']);
            return redirect()->route('buscheck.show')->with('status', 'Berhasil memverifikasi permintaan pengecekan bus');
        } 
        else if ($request->action == 'reject') {
            $checkOrder['status'] = 1;
            $busCheck->status = $checkOrder['status'];
            DB::table('bus_checks')
            ->where('id',$checkOrder['id'])
            ->update(['status'=>$checkOrder['status']]);
            // return response()->json(['False']);
            return redirect()->route('buscheck.show')->with('status', 'Berhasil memverifikasi permintaan pengecekan bus');
        }
    }

    public function storeBusCheckingUnit(Request $request)
    {
        if ($request->hull_code==null) {
            return response()->json(['Gagal membuat pengecekan bus'],500);
        } else {
            $busCheck = [
                'hull_code' => $request->hull_code,
                'user_id' => $request->user_id,
                'complaint' => $request->complaint,
                'date' => $request->date
            ];
            return response()->json(['Berhasil membuat pengecekan bus'],200);
        }
    }
}
