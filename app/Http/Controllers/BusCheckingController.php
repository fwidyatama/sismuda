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
class BusCheckingController extends Controller
{
    //
   public function showCheckingForm(){
       return view('officer.mechanic.buschecking');
   }

   public function storeBusChecking(Request $request){
       
    $validator = Validator::make($request->all(), [
        'complaint' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)
            ->withInput();
    }
    else{

        $check = new BusCheck();
        $check->user_id = Auth::user()->id;
        $check->hull_code = $request->hull_code;
        $check->complaint = $request->complaint;
        $check->date = Carbon::now();
       
       
       $check->save();
       
       $coordinatorEmail = User::where('id_role','=','1')->get();
       Mail::to($coordinatorEmail[0]->email)->send(new BusCheckMail());
       return redirect()->back()->with('status','Berhasil melakukan permintaan pengecekan');
    }
       
   }

   public function showBusCheck(){
       $checkOrders = BusCheck::with('user')->orderBy('date','DESC')->paginate(15);

       return view('coordinator.buscheck.dashboard',['checkOrders'=>$checkOrders]);
   }

   public function deleteOrder($id){
       $checkOrder = BusCheck::findOrFail($id);
       $checkOrder->delete();
       return redirect()->back()->with('status','Berhasil menghapus permintaan pengecekan');

   }

   public function detailOrder($id){
    $checkOrder = BusCheck::findOrFail($id);
    return view('coordinator.buscheck.detail',['checkOrder'=>$checkOrder]);
   }

   public function verifyOrder(Request $request,$id){
    $checkOrder = BusCheck::findOrFail($id);
    if ($request->action == 'approve') {
        $checkOrder->status = 2;
        $checkOrder->save();
        return redirect()->route('buscheck.show')->with('status','Berhasil memverifikasi permintaan pengecekan bus');
   }
   else if ($request->action == 'reject') {
        $checkOrder->status = 1;
        $checkOrder->save();
        return redirect()->route('buscheck.show')->with('status','Berhasil memverifikasi permintaan pengecekan bus');
   }
}
}
