<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

use Auth;

class AdminLoginController extends Controller
{

    public function __construct(){
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm(){
        return view('auth.admin-login');
    }

    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:9|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
            "password.required" => "Password is required",
            "password.min" => "Password must be at least 9 characters"
        ];

        //validate the request.
        $request->validate($rules, $messages);

    }

    public function login(Request $request)
    {
        $this->validator($request);

        if(Auth::guard('admin')->attempt($request->only('email','password'),$request->filled('remember'))){
            //Authentication passed...
            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('status','You are Logged in as Admin!');
        }

        //Authentication failed...
        return $this->loginFailed($request);
    }

    private function loginFailed(Request $request){
        return redirect()
            ->back()
            ->withInput($request->only('email','remember'))
            ->withErrors(
                [
                    'email' => 'These credentials do not match our records.'
                ]
            );
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()
            ->route('admin.login')
            ->with('status','Admin has been logged out!');
    }
}
