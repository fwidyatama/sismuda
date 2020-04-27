<?php

namespace App\Http\Controllers;

use App\Mail\SparepartOrderMail;
use Auth;
use App\Models\SparepartOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mail;

class SparepartOrderController extends Controller
{
    public function showOrderForm()
    {
        return view('officer.mechanic.sparepartorder');
    }

    public function storeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'quantity' => 'required|numeric',
            'unit_name' => 'required|max:10',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        } else {

            $sparepartOrder = new SparepartOrder();
            $sparepartOrder->user_id = Auth::user()->id;
            $sparepartOrder->hull_code = $request->hull_code;
            $sparepartOrder->sparepart_id = $request->sparepart;
            $sparepartOrder->type = $request->type;
            $sparepartOrder->date = Carbon::now();
            $sparepartOrder->quantity = $request->quantity;
            $sparepartOrder->unit_name = $request->unit_name;

            $sparepartOrder->save();

            $coordinatorEmail = User::where('id_role','=','1')->get();
            Mail::to($coordinatorEmail[0]->email)->send(new SparepartOrderMail());
        }

        return redirect()->back()->with('status', 'Berhasil menambah data sparepart');
    }

    public function getSparepart(Request $request)
    {
        $keyword = $request->q;
        $sparepart = \App\Models\Sparepart::all();
        return $sparepart;
    }
}
