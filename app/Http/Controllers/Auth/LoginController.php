<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;


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
//    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//    }

    public function index()
    {
        return view('auth.login');


    }


    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
            'password' => 'required'

        ]);


        if ($validator->fails()) {
            return redirect(route('login'))
                ->withErrors($validator)
                ->withInput();
        }


        $remember = $request->remember == 'on' ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {

            return redirect(route('contractIndex'));

        }

        return back()->withErrors('your password is incorrect');


    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');

    }

}