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
       return redirect()->back();
    }
       
   }
}
