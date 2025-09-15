<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function showLinkRequestForm()
    {
        return view('auth.password');
    }
    public function newPassword()
    {
        $title="New Password";
        return view('auth.new_password');
    }
    protected function broker()
    {
        return Password::broker('admin');
    }
    
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        \Log::info('Sending reset link for: ' . $request->email);

        $status = Password::broker('admin')->sendResetLink(
            $request->only('email')
        );

        \Log::info('Reset link status: ' . $status);
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'We have emailed your password reset link!'])
            : back()->withErrors(['email' => 'We can’t find a admin with that email address.']);
    }
}