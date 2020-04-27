<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Exports\SparepartReport;
use Maatwebsite\Excel\Facades\Excel;
class SparepartController extends Controller
{

    
    public function __construct()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Tidak dapat terhubung dengan database.");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showsparepartlist(Request $request)
    {
        $keyword = $request->keyword;
        if($keyword){
            $spareparts = Sparepart::where('name','LIKE',"%$keyword%")->paginate(10);;
        }
        else{

            $spareparts = Sparepart::orderBy('id','desc')->paginate(10);
        }
        return view('coordinator.sparepart.dashboard',['spareparts'=>$spareparts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSparepartForm()
    {
        return view ('coordinator.sparepart.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSparepart(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'code'=>'required',
            'name'=>'required',
            'brand' => 'required|max:30',
            'quantity' => 'required|numeric',
            'unit_name' => 'required|max:10',
            'price' => 'required|numeric',
        ]);
       

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
            ->withInput();
        } 
        else{
            $bus = new Sparepart();
            $bus->code = $request->code;
            $bus->name = $request->name;
            $bus->brand = $request->brand;
            $bus->quantity = $request->quantity;
            $bus->unit_name = $request->unit_name;
            $bus->price = $request->price;
            $bus->save();

            return redirect()->route('sparepart.showsparepartlist')->with('status', 'Berhasil menambah data sparepart');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function editSparepart ($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return view ('coordinator.sparepart.edit',['sparepart'=>$sparepart]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function updateSparepart(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code'=>'required',
            'name'=>'required',
            'brand' => 'required|max:30',
            'quantity' => 'required|numeric',
            'unit_name' => 'required|max:10',
            'price' => 'required|numeric',
        ]);
       

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
            ->withInput();
        } 
        else{
            $bus = Sparepart::findOrFail($id);
            $bus->code = $request->code;
            $bus->name = $request->name;
            $bus->brand = $request->brand;
            $bus->quantity = $request->quantity;
            $bus->unit_name = $request->unit_name;
            $bus->price = $request->price;
            $bus->save();

            return redirect()->route('sparepart.showsparepartlist')->with('status', 'Berhasil mengubah data sparepart');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sparepart  $sparepart
     * @return \Illuminate\Http\Response
     */
    public function deleteSparepart($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();
        return redirect()->back()->with('status', 'Berhasil menghapus data sparepart');
    }

    public function downloadSparepartReport (){
        return Excel::download(new SparepartReport, 'Sparepart Report.xlsx');
    }
}
