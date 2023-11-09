<?php

namespace App\Http\Controllers;

use Validator;
use Session;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
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
    protected $redirectTo = '/adminaccesspanel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getLogin()
    {
        return view('admin.login');
    }

    /**
     * Show the application loginprocess.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {

        $this->validate($request, [
            'login' => 'required',
            'password' => 'required',
        ]);
		
        if (auth()->guard('admin')->attempt(['login' => $request->input('login'), 'password' => $request->input('password')])) {
            $user = auth()->guard('admin')->user();       
            \Session::put('success','You are Login successfully!!');
			return response()->json(['status' => 'success', 'msg' => 'Ok',], 201);
			//return redirect()->route('admin');
        } else {
			$err = array();
			array_push($err, "Неверный логин или пароль.");
			return response()->json(['errors'=> ['error'=> $err]],422);
        }
		
    }

    /**
     * Show the application logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->guard('admin')->logout();
        \Session::flush();
        \Session::put('success','You are logout successfully');        
		return redirect(route('welcome'));
    }
}