<?php

namespace App\Http\Controllers\ClientArea\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
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
        return view('clientarea.auth.password');
    }
     public function newPassword()
    {
        $title="New Password";
        return view('clientarea.auth.new_password');
    }
    protected function broker()
    {
        return Password::broker('clients');
    }



    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        \Log::info('Sending reset link for: ' . $request->email);

        // Explicitly use the 'clients' broker
        $status = Password::broker('clients')->sendResetLink(
            $request->only('email')
        );

        \Log::info('Reset link status: ' . $status);
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Kami telah menghantar e-mel pautan tetapan semula kata laluan anda!'])
            : back()->withErrors(['email' => 'Alamat emel tidak wujud. Sila masukkan emel yang betul .']);
    }


    public function submitFeedback(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'comment' => 'required|string',
            'g-recaptcha-response' => 'required'
        ]);

        $recaptcha = $request->input('g-recaptcha-response');
        $secret = env('RECAPTCHA_SECRET_KEY');
        
        $verify = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$recaptcha);
        $response = json_decode($verify);
        
        if (!$response->success) {
            return back()->with('error', 'reCAPTCHA verification failed. Please try again.');
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'comment' => $validated['comment'],
            'submitted_at' => now()->format('d-m-Y H:i:s')
        ];

        // Send email
        try {
            Mail::send('emails.feedback', $data, function($message) use ($data) {
                $message->to('ecp@selangor.gov.my')
                        ->subject('Portal e-CP Feedback - ' . $data['name'])
                        ->replyTo($data['email'], $data['name']);
            });

            return back()->with('success', 'Terima kasih! Maklum balas anda telah dihantar.');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf, terdapat masalah menghantar maklum balas. Sila cuba lagi.');
        }
    }
}