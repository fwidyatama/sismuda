<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Tzsk\Sms\Facade\Sms;



class UserController extends Controller
{


    public function __construct()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Tidak dapat terhubung dengan database.");
        }
    }

    public function showOfficerList(Request $request)
    {
        $filter = $request->keyword;
        if ($filter) {
            $users = User::where('name', 'LIKE', "%$filter%")->paginate(10);;
        } else {
            $users = User::paginate(10);
        }
        return view('coordinator.officer.dashboard', ['users' => $users]);
    }

    public function showOfficerForm()
    {
        return view('coordinator.officer.create');
    }

    public function storeOfficer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|min:3',
            'email' => 'required|min:3',
            'role' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|min:10',
            'password' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->id_role = $request->role;
            $user->phone_number = $request->phone;
            $user->expertness = $request->expertness;
            $user->address = $request->address;
            $user->password = \Hash::make($request->password);

            $user->save();
            return redirect()->route('user.showofficerlist')->with('status', 'Berhasil menambah data karyawan');
        }
    }

    public function destroyOfficer($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('status', 'Berhasil menghapus data karyawan');
    }

    public function editOfficer($id)
    {
        $user = User::findOrFail($id);
        return view('coordinator.officer.edit', ['user' => $user]);
    }

    public function updateOfficer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|min:3',
            'email' => 'required|min:3',
            'role' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|min:10',
            'password' => 'required|min:5'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        } else {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->id_role = $request->role;
            $user->phone_number = $request->phone;
            $user->expertness = $request->expertness;
            $user->address = $request->address;
            $user->password = \Hash::make($request->password);

            $user->save();
            return redirect()->route('user.showofficerlist')->with('status', 'Berhasil mengubah data karyawan');
        }
    }

    public function showProfile($id){
        $user = User::findOrFail($id);
        return view('coordinator.officer.detail', ['user' => $user]);
    }

    

    public function send()
    {
        Sms::via('smsgatewayme')->send("this message", function($sms) {
            $sms->to(['']);
        });
    }

    public function form(){
        return view ('form');
    }

  
}
