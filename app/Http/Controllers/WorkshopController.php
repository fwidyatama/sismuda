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

    public function storeWorkshop($hullCode, $user_id, $note, $workType,$workshopNumber)
    {
      
        $workshop = new Workshop();
        $workshop->hull_code = $hullCode;
        $workshop->user_id = $user_id;
        $workshop->order_date = Carbon::now();
        $workshop->workshop_number = $workshopNumber;
        $workshop->note = $note;
        $workshop->work_type = $workType;
        $workshop->save();

        $user = User::where('id','=',$user_id)->get();
        Mail::to($user[0]->email)->send(new WorkshopEmail());
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
        }
        else{
            $userIds = $request->user;
            foreach ($userIds as $key => $value) {
                $hullCode = $request->hull_code;
                $note = $request->note;
                $workType = $request->work_type;
                $workshopNumber = $request->workshop_number;
                $this->storeWorkshop($hullCode, $userIds[$key], $note, $workType,$workshopNumber);
            }
        }

        return redirect()->route('workshop.showworkshop')->with('status', 'Berhasil membuat Surat tugas');
    }


    //make attach bisa buat edit. Buat edit nanti make sync bukan attach.
    // $bus = Bus::findOrFail($hullCode);
    // $data = [];
    // foreach ($userIds as $userId) {
    //     $data[$userId] = [
    //         'order_date' => Carbon::now(),
    //         'note' => $request->note,
    //         'work_type' => $request->work_type
    //     ];
    // }
    // $bus->user()->attach($data);       

    //make mass assignment



    // $validator = Validator::make($request->all(), [
    //     'work_type' => 'required',
    //     'note' => 'required',
    // ]);

    // if ($validator->fails()) {
    //     return redirect()->back()->withErrors($validator)
    //         ->withInput();
    // } else {
    //     $rowCount=count(Workshop::all());

    //     $userIds = $request->user;
    //     foreach ($userIds as $userId) {
    //         $data =  [
    //             'workshop_number' =>$rowCount,
    //             'hull_code' => $request->hull_code,
    //             'user_id' => $userId,
    //             'order_date' => Carbon::now(),
    //             'note' => $request->note,
    //             'work_type' => $request->work_type
    //         ];

    //         \App\Models\Workshop::create($data);
    //     }

    //     $idOfficer =User::findMany($request->user);

    //     $email = [];

    //     foreach ($idOfficer as $user){

    //     $email []= $user->email;


    //     Mail::to($user->email)->send(new WorkshopEmail($email));
    //     }

    //     return redirect()->route('workshop.showworkshop')->with('status', 'Berhasil membuat Surat tugas');


    // }
    // }

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
}
