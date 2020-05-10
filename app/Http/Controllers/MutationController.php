<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutation;
use App\Models\Sparepart;
use Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SparepartMutation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Switch_;

class MutationController extends Controller
{
    public function addMutation()
    {
        $spareparts = Sparepart::all();
        return view('officer.logistic.addmutation', ['spareparts' => $spareparts]);
    }

    public function showMutation(Request $request)
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
            return Excel::download(new SparepartMutation($month, $year), "Mutasi_{$monthTitle}_${year}.xlsx");
        }

        $mutations = DB::table('mutates')
            ->join('users', 'users.id', '=', 'mutates.user_id')
            ->join('spareparts', 'spareparts.id', '=', 'mutates.sparepart_id')
            ->select('mutates.*', 'users.name as user_name', 'spareparts.name as sparepart_name', 'spareparts.price as sparepart_price', 'spareparts.quantity as stock')
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('mutates.date', $month);
            })
            ->when($month, function ($query) use ($year) {
                return $query->whereYear('mutates.date', $year);
            })
            ->orderByDesc('created_at')
            ->paginate(15);
        return view('officer.logistic.dashboardmutation', ['mutations' => $mutations, 'month' => $month]);
    }

    public function sparepart($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        return $sparepart;
    }

    public function storeMutation($sparepartId, $status, $quantity, $type)
    {
        if ($status == 'entry') {
            $sparepartCounter = $this->sparepart($sparepartId)->quantity;
            // dd($sparepartCounter);
            $sparepartPrice = $this->sparepart($sparepartId)->price;
            $mutation = new Mutation();
            $mutation->user_id = Auth::user()->id;
            $mutation->sparepart_id = $sparepartId;
            $mutation->status = $status;
            $mutation->date = Carbon::now();
            $mutation->quantity = $quantity;
            $mutation->price = $sparepartPrice;
            $mutation->type = $type;
            $mutation->total = $quantity + $sparepartCounter;
            $mutation->save();

            Sparepart::where('id', $sparepartId)->update([
                    'quantity' => $quantity + $sparepartCounter
                ]);
        } else if ($status == 'out') {
            $sparepartCounter = $this->sparepart($sparepartId)->quantity;
            // dd($sparepartCounter);
            $sparepartPrice = $this->sparepart($sparepartId)->price;
            $mutation = new Mutation();
            $mutation->user_id = Auth::user()->id;
            $mutation->sparepart_id = $sparepartId;
            $mutation->status = $status;
            $mutation->date = Carbon::now();
            $mutation->quantity = $quantity;
            $mutation->price = $sparepartPrice;
            $mutation->type = $type;
            $mutation->total = $sparepartCounter - $quantity;
            $mutation->save();

            Sparepart::where('id', $sparepartId)->update([
                    'quantity' => $sparepartCounter - $quantity
                ]);
        }
    }

    public function storeMutations(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        } else {

            $spareparts = $request->sparepart;
            foreach ($spareparts as $key => $sparepart) {
                $sparepartId = $request->sparepart;
                $status = $request->status;
                $quantity = $request->quantity;
                $type = $request->type;
                $this->storeMutation($sparepartId[$key], $status[$key], $quantity[$key], $type);
            }
            return redirect()->back()->with('status', 'Berhasil menambah mutasi suku cadang');
        }
    }
}
