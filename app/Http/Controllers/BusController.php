<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BusController extends Controller
{

    public function __construct()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Tidak dapat terhubung dengan database.");
        }
    }
    public function showBusList()
    {
        $buses = Bus::paginate(10);

        return view('coordinator.bus.dashboard', ['buses' => $buses]);
    }

    public function showBusForm()
    {
        return view('coordinator.bus.create');
    }


    public function storeBus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required|max:30',
            'type' => 'required|max:15',
            'police_number' => 'required|max:10',
            'hull_code' => 'required|numeric|min:2',
            'license_date' => 'required'
        ]);
       

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
            ->withInput();
        } 
        else{
            $bus = new Bus();
            $bus->hull_code = $request->hull_code;
            $bus->brand = $request->brand;
            $bus->type = $request->type;
            $bus->police_number = $request->police_number;
            $bus->license_date = Carbon::parse($request->license_date)->format('Y-m-d');
            $bus->save();

            return redirect()->route('bus.showbuslist')->with('status', 'Berhasil menambah data bus');
        }
    }
    public function deleteBus($hullcode){
        $bus = Bus::findOrFail($hullcode);
        $bus->delete();

        return redirect()->back()->with('status', 'Berhasil menghapus data bus');
    }

    public function editBus($hullcode){
        $bus = Bus::findOrFail($hullcode);
        return view('coordinator.bus.edit', ['bus' => $bus]);
    }

    public function updateBus(Request $request, $hullcode){
        
        $validator = Validator::make($request->all(), [
            'brand' => 'required|max:30',
            'type' => 'required|max:15',
            'police_number' => 'required|max:10',
            'hull_code' => 'required|numeric|min:2',
            'license_date' => 'required'
        ]);
       

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
            ->withInput();
        } 
        else{
            $bus = Bus::findOrFail($hullcode);
            $bus->brand = $request->brand;
            $bus->type = $request->type;
            $bus->police_number = $request->police_number;
            $bus->hull_code = $request->hull_code;
            $bus->license_date = Carbon::parse($request->license_date)->format('Y-m-d');
            $bus->save();

            return redirect()->route('bus.showbuslist')->with('status', 'Berhasil mengubah data bus');
    }
}
}
