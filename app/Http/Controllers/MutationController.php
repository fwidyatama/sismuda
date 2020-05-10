<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutation;
use App\Models\Sparepart;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class MutationController extends Controller
{
    public function addMutation()
    {
        $spareparts = Sparepart::all();
        return view('officer.logistic.addmutation', ['spareparts' => $spareparts]);
    }

    public function showMutation(){
        // $mutations = Mutation::with('user')->paginate(15);
        $mutations = DB::table('mutates')
        ->join('users', 'users.id', '=', 'mutates.user_id')
        ->join('spareparts', 'spareparts.id', '=', 'mutates.sparepart_id')
        ->select('mutates.*', 'users.name as user_name', 'spareparts.name as sparepart_name','spareparts.price as sparepart_price','spareparts.quantity as stock')
        ->orderByDesc('date')
        ->paginate(15);
        // dd($mutations);
        return view('officer.logistic.dashboardmutation',['mutations'=>$mutations]);
    }

    public function sparepart($id){
        $sparepart = Sparepart::findOrFail($id);
        return $sparepart;
    }

    public function storeMutation($sparepartId,$status,$quantity,$type){
        if($status=='entry'){
            $sparepartCounter = $this->sparepart($sparepartId)->quantity;
            $sparepartPrice = $this->sparepart($sparepartId)->price;
            $mutation = new Mutation();
            $mutation->user_id = Auth::user()->id;
            $mutation->sparepart_id =$sparepartId;
            $mutation->status= $status;
            $mutation->date= Carbon::now();
            $mutation->quantity= $quantity;
            $mutation->price = $sparepartPrice;
            $mutation->type = $type;
            $mutation->save();

            Sparepart::where('id',$sparepartId)->
            update([
                'quantity' => $quantity + $sparepartCounter
            ]);
        }
        else if($status=='out'){
            $sparepartCounter = $this->sparepart($sparepartId)->quantity;
            $sparepartPrice = $this->sparepart($sparepartId)->price;
            $mutation = new Mutation();
            $mutation->user_id = Auth::user()->id;
            $mutation->sparepart_id =$sparepartId;
            $mutation->status= $status;
            $mutation->date= Carbon::now();
            $mutation->quantity= $quantity;
            $mutation->price = $sparepartPrice;
            $mutation->type = $type;
            $mutation->save();

            Sparepart::where('id',$sparepartId)->
            update([
                'quantity' => $quantity - $sparepartCounter
            ]);
        }
        
    }

    public function storeMutations(Request $request){
        $validator = Validator::make($request->all(),[
            'type' =>'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)
            ->withInput();
        }
        else{

            $spareparts = $request->sparepart;
            foreach ($spareparts as $key => $sparepart) {
                $sparepartId = $request->sparepart;
                $status = $request->status;
                $quantity = $request->quantity;
                $type = $request->type;
                $this->storeMutation($sparepartId[$key],$status[$key],$quantity[$key],$type);
            }
            return redirect()->back()->with('status', 'Berhasil menambah mutasi suku cadang');
        }
    }
}
