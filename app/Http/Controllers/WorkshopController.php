<?php

namespace App\Http\Controllers;

use App\Mail\WorkshopEmail;
use App\Models\Workshop;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mail;
use Auth;


class WorkshopController extends Controller
{

    public function __construct()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Tidak dapat terhubung dengan database.");
        }
    }


    public function showWorkShopForm()
    {
        return view('coordinator.workshop.create');
    }

    public function storeWorkshop(Request $request)
    {
        $hullCode = $request->hull_code;
        if ($hullCode != null) {
            $workshop = new Workshop();
            $workshop->hull_code = $request->hull_code;
            $workshop->user_id = $request->user_id;
            $workshop->order_date = $request->order_date;
            $workshop->workshop_number = $request->workshop_number;
            $workshop->note = $request->note;
            $workshop->work_type = $request->work_type;
            $workshop->save();

            $user = User::where('id', '=', $request->user_id)->first();
            Mail::to($user->email)->send(new WorkshopEmail());
            return response()->json(['True'], 200);
        } else {
            return response()->json(['False'], 500);
        }
    }

    public function storeWorkshops(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'work_type' => 'required',
            'note' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        } else {
            $hullCode = $request->hull_code;
            $workshopNumber = $request->workshop_number;
            $note = $request->note;
            $workType = $request->work_type;
            $userId = $request->user;
            $date = Carbon::now();
            $request = new Request();

            foreach ($userId as $key => $value) {
                $data = [
                    'user_id' => $userId[$key],
                    'hull_code' => $hullCode,
                    'order_date' => $date,
                    'workshop_number' => $workshopNumber,
                    'note' => $note,
                    'work_type' => $workType,
                ];
                $request->merge($data);
                $this->storeWorkshop($request);
            }
        }

        return redirect()->route('workshop.showworkshop')->with('status', 'Berhasil membuat Surat tugas');
    }
    public function showWorkshopList(Request $request)
    {

        $keyword = $request->keyword;
        $workshops = DB::table('workshops')
            ->join('users', 'users.id', '=', 'workshops.user_id')
            ->select('workshops.*', 'users.name as user_name')
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('hull_code', 'LIKE', "$keyword");
            })
            ->orderByDesc('order_date')
            ->get()
            ->groupBy(['order_date', 'work_type', 'hull_code']);

        $data = [];


        foreach ($workshops as $orderDate => $groupedByOrderDate) {
            foreach ($groupedByOrderDate as $workType => $groupedByWorkType) {
                foreach ($groupedByWorkType as $hullCode => $groupedByHullCode) {
                    $tempData = [
                        'order_date' => $orderDate,
                        'work_type' =>  $workType,
                        'hull_code' =>  $hullCode,
                        'name' => []
                    ];
                    foreach ($groupedByHullCode as $row) {
                        $tempData['name'][] = $row->user_name;
                        $tempData['detail'] = $row->note;
                        $tempData['workshopnumber'] = $row->workshop_number;
                        $tempData['status'] = $row->status;
                    }
                    $data[] = $tempData;
                }
            }
        }


        return view('coordinator.workshop.dashboard', ['workshops' => $data]);
    }

    public function deleteWorkshop($workshopnumber)
    {
        Workshop::where('workshop_number', $workshopnumber)->delete();
        return redirect()->route('workshop.showworkshop')->with('status', 'Berhasil menghapus Surat tugas');
    }


    public function getUserAjax(Request $request)
    {
        $keyword = $request->q;
        $user = \App\Models\User::where('id_role', 2)->get();
        return $user;
    }

    public function getBusAjax(Request $request)
    {
        $keyword = $request->q;
        $bus = \App\Models\Bus::all();
        return $bus;
    }

    public function showHistory()
    {
        $user = Auth::user()->id;

        $workshops = DB::table('workshops')
            ->join('users', 'users.id', '=', 'workshops.user_id')
            ->select('workshops.*', 'users.name as user_name')
            ->where(function ($query) use ($user) {
                $query->orWhere('workshops.user_id', 'like', '%' . $user . '%');
            })
            ->orderByDesc('order_date')
            ->get()
            ->groupBy(['order_date', 'work_type', 'hull_code']);

        $data = [];


        foreach ($workshops as $orderDate => $groupedByOrderDate) {
            foreach ($groupedByOrderDate as $workType => $groupedByWorkType) {
                foreach ($groupedByWorkType as $hullCode => $groupedByHullCode) {
                    $tempData = [
                        'order_date' => $orderDate,
                        'work_type' =>  $workType,
                        'hull_code' =>  $hullCode,
                        'name' => []
                    ];
                    foreach ($groupedByHullCode as $row) {
                        $tempData['name'][] = $row->user_name;
                        $tempData['detail'] = $row->note;
                        $tempData['workshopnumber'] = $row->workshop_number;
                        $tempData['date'] = $row->order_date;
                        $tempData['status'] = $row->status;
                    }
                    $data[] = $tempData;
                }
            }
        }

        return view('officer.mechanic.workshop', ['workshops' => $data]);
    }


    public function storeWorkshopUnit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'work_type' => 'required',
            'note' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        } else {
            $workshop = new Workshop();
            $workshop->hull_code = $request->hull_code;
            $workshop->user_id = $request->user_id;
            $workshop->order_date = Carbon::now();
            $workshop->workshop_number = $request->workshop_number;
            $workshop->note = $request->note;
            $workshop->work_type = $request->work_type;
            $workshop->save();
        }
    }
}
