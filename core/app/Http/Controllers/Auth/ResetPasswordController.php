<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Validator;
use DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    protected $redirectTo = '/';

    /**
     * ResetPasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function showResetForm(Request $request, $token = null)
    {
        \Log::info('showResetForm called with token: ' . $token . ', email: ' . $request->email);
        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    
    protected function guard()
    {
        return Auth::guard('admin');
    }
    
    protected function broker()
    {
        return Password::broker('admin');
    }
    
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        
        Log::info('Reset request payload: ' . json_encode($request->all()));
        
        $status = $this->broker()->reset(
            $request->only('email', 'token', 'password', 'password_confirmation'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->force_password_reset = false;
                $user->save();
                
                DB::table('password_attempts')
                ->where('admin_id', $user->uuid)
                ->delete();
                Log::info('Password updated for user: ' . $user->email);
            }
        );
        
        Log::info('Reset status: ' . $status);
        
        if ($status === Password::PASSWORD_RESET) {
            return back()->with('reset_success', trans('passwords.reset'));
        } else {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($status)]);
        }
    }
}