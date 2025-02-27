<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BusPermit;
use App\Models\Workshop;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class BusPermitController extends Controller
{

    public function __construct()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Tidak dapat terhubung dengan database.");
        }
    }

    public function showList()
    {
        $permits = BusPermit::with('user')->orderBy('date', 'DESC')->paginate(15);
        return view('coordinator.permits.dashboard', ['permits' => $permits]);
    }

    public function deleteList($id)
    {
        $permit = BusPermit::findOrFail($id);
        $permit->delete();
        return redirect()->back()->with('status', 'Berhasil menghapus daftar');
    }

    public function showPermitForm()
    {
        $workshopsNumber = DB::table('workshops')
            ->select('workshops.workshop_number')
            ->where(['workshops.user_id' => Auth::user()->id, 'workshops.status' => 0])
            ->get();
        return view('officer.mechanic.buspermit', ['workshopsNumber' => $workshopsNumber]);
    }

    public function storePermit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hull_code' => 'required',
            'workshopnumber' => 'required',
            'note' => 'required'
        ], [
            'workshopnumber.required' => 'Field harus diisi',
            'note.required' => 'Field harus diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->route('permits.request')->with('error', 'Semua field harus diisi');
        } else {
            $workshopNumber = $request->workshopnumber;
            $permit = new BusPermit();
            $workshop = new Workshop();
            $permit->hull_code = $request->hull_code;
            $permit->user_id = Auth::user()->id;
            $permit->workshop_number = $workshopNumber;
            $permit->note = $request->note;
            $permit->date = Carbon::now();
            $workshop->changeStatus($request->workshopnumber);
            $permit->save();
            return redirect()->route('permits.request')->with('status', 'Berhasil menambah data kendaraan yang sudah selesai diperbaiki');
        }
    }

    public function storePermitUnit(Request $request)
    {
        if ($request->hull_code==null) {
            return response()->json(['Gagal menambah data'],500);
        } else {
            $busPermit = [
                'hull_code' => $request->hull_code,
                'user_id' => $request->user_id,
                'date' => $request->date,
                'workshop_number' => $request->workshop_number,
                'note' => $request->note,
            ];
            return response()->json(['Berhasil menambah data'],200);
        }
    }

}
