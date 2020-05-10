<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo;
    
    public function redirectTo(){
        switch(Auth::user()->id_role){
            case 1:
                $this->redirectTo = '/officer/showofficer';
                return $this->redirectTo;
            break;
            case 2:
                $this->redirectTo = '/workshop/history';
                return $this->redirectTo;
            break;
            case 3:
                $this->redirectTo = '/sparepart/showsparepart';
                return $this->redirectTo;
            break;
            case 4:
                $this->redirectTo = '/buscheck/requestcheck';
                return $this->redirectTo;
            break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    


}
