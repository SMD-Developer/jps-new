<?php namespace App\Http\Controllers\ClientArea\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\ClientRegisterModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Models\PasswordAttempt;
use App\Models\OtpVerification;
use App\Models\Client as ClientUser ;
use Carbon\Carbon;
use Illuminate\Support\Facades\auth;
use App\Notifications\OtpVerificationNotification;

class AuthController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/
    use AuthenticatesUsers;

	protected $loginPath = '/clientarea/login';
	//protected $username = 'username';

	public function __construct(){
		$this->middleware('guest', ['except' => 'getLogout']);
	}
    public function getLogin(){
        $states = DB::table('state')->where('status', 1)->orderBy('negeri_code', 'asc')->get();
        $districts = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
       $division = DB::table('division')->where('status', 1)->orderBy('mukim_code', 'asc')->get();
        return view('clientarea.auth.login', compact(['states', 'districts', 'division']));
    }
//     public function postLogin(Request $request){
// 		// get our login input
// 		$login = $request->input('login');
// 		// check login field
// 		$login_type = filter_var($login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
// 		// merge our login field into the request with either email or username as key
// 		$request->merge([ $login_type => $login ]);
// 		// let's validate and set our credentials
//         $this->validate($request, [
//             'email'    => 'required|email',
//             'password' => 'required',
//         ]);
//         $credentials = $request->only( 'email', 'password' );
//         $loggedIn = auth('user')->attempt($credentials,$request->has('remember'));
//         if($request->ajax()){
//             if($loggedIn){
//                 return response()->json([
//                     'success' => true,
//                     'message' => 'login successful!',
//                     'action'=>'redirect',
//                     'redirect_url' => route('client_application', auth()->guard('user')->user()->uuid)
//                 ]);
//             }

//             return response()->json([
//                 'success' => false,
//                 'message' => 'Username and password do not match!',
//                 'action'=>'show_msg'
//             ],422);
//         }
//         if($loggedIn){
//             return redirect()->route('update_profile', auth()->guard('user')->user()->uuid);
//         }
// 		return redirect()->back()->withInput($request->only('login', 'remember'))->withErrors(['login' => 'Invalid Login Credentials !']);
// 	}

//   public function postLogin(Request $request)
//     {
//         $login = $request->input('login');
//         $login_type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
//         $request->merge([$login_type => $login]);
        
//          if (empty($login) && empty($password)) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Emel dan kata laluan tidak boleh dibiarkan kosong',
//             ], 422);
//         }

//         $this->validate($request, [
//             'email' => 'required|email',
//             'password' => 'required',
//         ]);
        
//         $credentials = $request->only('email', 'password');
//         $identifier = $request->email;
//         $client = Client::where('email', $identifier)->first();

//         if ($client) {
//             $lockedUntil = $this->getUserLockoutTime($client->uuid);
//             if ($lockedUntil && $lockedUntil > now()) {
//                 $remainingTime = now()->diffInMinutes($lockedUntil) + 1;
                
//                 if ($request->ajax()) {
//                     return response()->json([
//                         'success' => false,
//                         'message' => __('app.account_locked', ['minutes' => $remainingTime]),
//                     ], 401);
//                 }
//                 return redirect()->back()->withInput($request->only('login', 'remember'))
//                     ->withErrors(['login' => __('app.account_locked', ['minutes' => $remainingTime])]);
//             }
//         }

//         $loggedIn = auth('user')->attempt($credentials, $request->has('remember'));
        
//         if ($loggedIn) {
//             $this->resetFailedAttempts(auth('user')->user()->uuid);
            
//             if ($request->ajax()) {
//                 return response()->json([
//                     'success' => true,
//                     'message' => 'Login successful!',
//                     'action' => 'redirect',
//                     'redirect_url' => route('client_application', auth('user')->user()->uuid)
//                 ]);
//             }
//             return redirect()->route('update_profile', auth('user')->user()->uuid);
//         }
        
//         if ($client) {
//             $this->recordFailedAttempt($client->uuid);
//             $attempts = $this->getFailedAttempts($client->uuid);
//             $remainingAttempts = 5 - $attempts;
            
//             if ($attempts >= 5) {
//                 $this->lockUserAccount($client->uuid);
                
//                 if ($request->ajax()) {
//                     return response()->json([
//                         'success' => false,
//                         'message' => __('account locked maximum attempt reached', ['minutes' => 30]),
//                     ], 401);
//                 }
//                 return redirect()->back()->withInput($request->only('login', 'remember'))
//                     ->withErrors(['login' => __('account locked maximum attempt reached', ['minutes' => 30])]);
//             }
            
//             $message = __('auth.failed') . ' ' . __($remainingAttempts . ' attempts remaining.');
            
//             if ($request->ajax()) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => $message,
//                     'action' => 'show_msg'
//                 ], 422);
//             }
//             return redirect()->back()->withInput($request->only('login', 'remember'))
//                 ->withErrors(['login' => $message]);
//         }
        
//         $message = 'Username and password do not match!';
        
//         if ($request->ajax()) {
//             return response()->json([
//                 'success' => false,
//                 'message' => $message,
//                 'action' => 'show_msg'
//             ], 422);
//         }
//         return redirect()->back()->withInput($request->only('login', 'remember'))
//             ->withErrors(['login' => 'Invalid Login Credentials!']);
//     }



    // public function postLogin(Request $request)
    // {
    //     $login = $request->input('login');
    //     $password = $request->input('password');
        
    //     if (empty($login) && empty($password)) {
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Emel dan kata laluan tidak boleh dibiarkan kosong',
    //             ], 422);
    //         }
    //         return redirect()->back()->withInput($request->only('login', 'remember'))
    //             ->withErrors(['login' => 'Emel dan kata laluan tidak boleh dibiarkan kosong']);
    //     }
        

    //     if (empty($password)) {
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Kata laluan perlu diisi',
    //             ], 422);
    //         }
    //         return redirect()->back()->withInput($request->only('login', 'remember'))
    //             ->withErrors(['password' => 'Kata laluan perlu diisi']);
    //     }
        
    //     if (empty($login)) {
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'E-mel diperlukan',
    //             ], 422);
    //         }
    //         return redirect()->back()->withInput($request->only('login', 'remember'))
    //             ->withErrors(['login' => 'E-mel diperlukan']);
    //     }
        
    //     $login_type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    //     $request->merge([$login_type => $login]);
        
    //     // Validate the request (this will handle format validation)
    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ], [
    //         'email.required' => 'E-mel diperlukan',
    //         'email.email' => 'Format e-mel tidak sah',
    //         'password.required' => 'Kata laluan perlu diisi',
    //     ]);
        
    //     $credentials = $request->only('email', 'password');
    //     $identifier = $request->email;
        
    //     // Check if client exists in database
    //     $client = Client::where('email', $identifier)->first();
        
    //     if (!$client) {
    //         // Client not found in database
    //         $message = 'E-mel tiada dalam rekod kami. Sila daftar di Daftar di sini';
            
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $message,
    //                 'action' => 'show_msg',
    //                 // 'register_url' => route('client_register') // Include register URL for frontend
    //             ], 422);
    //         }
    //         return redirect()->back()->withInput($request->only('login', 'remember'))
    //             ->withErrors(['login' => $message]);
    //     }
        
    //     // Check if account is locked
    //     $lockedUntil = $this->getUserLockoutTime($client->uuid);
    //     if ($lockedUntil && $lockedUntil > now()) {
    //         $remainingTime = now()->diffInMinutes($lockedUntil) + 1;
            
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => __('app.account_locked', ['minutes' => $remainingTime]),
    //             ], 401);
    //         }
    //         return redirect()->back()->withInput($request->only('login', 'remember'))
    //             ->withErrors(['login' => __('app.account_locked', ['minutes' => $remainingTime])]);
    //     }
        
    //     // Attempt login
    //     $loggedIn = auth('user')->attempt($credentials, $request->has('remember'));
        
    //     if ($loggedIn) {
    //         $this->resetFailedAttempts(auth('user')->user()->uuid);
            
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Login successful!',
    //                 'action' => 'redirect',
    //                 'redirect_url' => route('client_application', auth('user')->user()->uuid)
    //             ]);
    //         }
    //         return redirect()->route('update_profile', auth('user')->user()->uuid);
    //     }
        
    //     // Login failed - record failed attempt
    //     $this->recordFailedAttempt($client->uuid);
    //     $attempts = $this->getFailedAttempts($client->uuid);
    //     $remainingAttempts = 5 - $attempts;
        
    //     if ($attempts >= 5) {
    //         $this->lockUserAccount($client->uuid);
            
    //         $lockMessage = 'Akaun dikunci kerana maksimum percubaan dicapai. Cuba lagi dalam 30 minit.';
            
    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $lockMessage,
    //             ], 401);
    //         }
    //         return redirect()->back()->withInput($request->only('login', 'remember'))
    //             ->withErrors(['login' => $lockMessage]);
    //     }
        
    //     // Wrong password - show remaining attempts with forgot password link
    //     $message = 'E-mel dan kata laluan tidak sepadan. Klik Lupa kata laluan jika anda lupa kata laluan. Anda mempunyai ' . $remainingAttempts . ' cubaan lagi.';
        
    //     if ($request->ajax()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $message,
    //             'action' => 'show_msg',
    //             // 'forgot_password_url' => route('client_forgot_password') // Include forgot password URL
    //         ], 422);
    //     }
    //     return redirect()->back()->withInput($request->only('login', 'remember'))
    //         ->withErrors(['login' => $message]);
    // }
    
     public function postLogin(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');
        
        if (empty($login) && empty($password)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Emel dan kata laluan tidak boleh dibiarkan kosong',
                ], 422);
            }
            return redirect()->back()->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => 'Emel dan kata laluan tidak boleh dibiarkan kosong']);
        }
        
    
        if (empty($password)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kata laluan perlu diisi',
                ], 422);
            }
            return redirect()->back()->withInput($request->only('login', 'remember'))
                ->withErrors(['password' => 'Kata laluan perlu diisi']);
        }
        
        if (empty($login)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'E-mel diperlukan',
                ], 422);
            }
            return redirect()->back()->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => 'E-mel diperlukan']);
        }
        
        $login_type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$login_type => $login]);
        
        // Validate the request (this will handle format validation)
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'E-mel diperlukan',
            'email.email' => 'Format e-mel tidak sah',
            'password.required' => 'Kata laluan perlu diisi',
        ]);
        
        $credentials = $request->only('email', 'password');
        $identifier = $request->email;
        
        // Check if client exists in database
        $client = Client::where('email', $identifier)->first();
        
        if (!$client) {
            // Client not found in database
            $message = 'E-mel tiada dalam rekod kami. Sila daftar di Daftar di sini';
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'action' => 'show_msg',
                    // 'register_url' => route('client_register') // Include register URL for frontend
                ], 422);
            }
            return redirect()->back()->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => $message]);
        }
        
        // **NEW: Check if email is verified**
        $clientRegister = ClientRegisterModel::where('email', $identifier)
            ->where('client_id', $client->uuid)
            ->first();
        
        if ($clientRegister && !$clientRegister->is_email_verified) {
            // Email not verified - prevent login and offer to resend verification
            \Log::info('Login attempt with unverified email', [
                'email' => $identifier,
                'client_id' => $client->uuid
            ]);
            
            // Check if there's an active OTP
            $hasActiveOtp = OtpVerification::where('email', $identifier)
                ->where('type', 'registration')
                ->where('is_verified', false)
                ->where('expires_at', '>', now())
                ->exists();
            
            $message = 'Alamat e-mel anda tidak disahkan. Sila sahkan e-mel anda untuk log masuk.';
            $actionMessage = $hasActiveOtp 
                ? 'Semak e-mel anda untuk kod pengesahan atau klik di bawah untuk menghantar semula.'
                : 'Klik di bawah untuk menerima kod pengesahan baharu.';
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'action' => 'email_not_verified',
                    'action_message' => $actionMessage,
                    'email' => $identifier,
                    'verification_url' => route('otp.verification') . '?email=' . urlencode($identifier),
                    'has_active_otp' => $hasActiveOtp
                ], 403);
            }
            
            // For non-AJAX requests, redirect to OTP verification page
            return redirect()->route('otp.verification', ['email' => $identifier])
                ->with('warning', $message . ' ' . $actionMessage);
        }
        
        // Check if account is locked
        $lockedUntil = $this->getUserLockoutTime($client->uuid);
        if ($lockedUntil && $lockedUntil > now()) {
            $remainingTime = now()->diffInMinutes($lockedUntil) + 1;
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('app.account_locked', ['minutes' => $remainingTime]),
                ], 401);
            }
            return redirect()->back()->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => __('app.account_locked', ['minutes' => $remainingTime])]);
        }
        
        
        // ADD THIS CHECK FOR FORCE PASSWORD RESET - RIGHT HERE
            if ($client->force_password_reset) {
                $message = 'Anda mesti menetapkan semula kata laluan anda sebelum log masuk. Sila semak e-mel anda untuk mendapatkan arahan tetapan semula kata laluan.';
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'action' => 'password_reset_required'
                    ], 401);
                }
                return redirect()->back()->withInput($request->only('login', 'remember'))
                    ->withErrors(['login' => $message]);
            }
        
        // Attempt login
        $loggedIn = auth('user')->attempt($credentials, $request->has('remember'));
        
        if ($loggedIn) {
            $this->resetFailedAttempts(auth('user')->user()->uuid);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'action' => 'redirect',
                    'redirect_url' => route('client_application', auth('user')->user()->uuid)
                ]);
            }
            return redirect()->route('update_profile', auth('user')->user()->uuid);
        }
        
        // Login failed - record failed attempt
        $this->recordFailedAttempt($client->uuid);
        $attempts = $this->getFailedAttempts($client->uuid);
        $remainingAttempts = 5 - $attempts;
        
        if ($attempts >= 5) {
            $this->lockUserAccount($client->uuid);
            
            $lockMessage = 'Akaun dikunci kerana maksimum percubaan dicapai. Cuba lagi dalam 30 minit.';
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $lockMessage,
                ], 401);
            }
            return redirect()->back()->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => $lockMessage]);
        }
        
        // Wrong password - show remaining attempts with forgot password link
        $message = 'E-mel dan kata laluan tidak sepadan. Klik Lupa kata laluan jika anda lupa kata laluan. Anda mempunyai ' . $remainingAttempts . ' cubaan lagi.';
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'action' => 'show_msg',
                // 'forgot_password_url' => route('client_forgot_password') // Include forgot password URL
            ], 422);
        }
        return redirect()->back()->withInput($request->only('login', 'remember'))
            ->withErrors(['login' => $message]);
    }
    
    private function recordFailedAttempt($clientId)
    {
        PasswordAttempt::create([
            'client_id' => $clientId,
            'attempt_time' => Carbon::now(),
            'successful' => false
        ]);
    }
    
    /**
     * Get number of recent failed attempts (last 30 minutes)
     */
    private function getFailedAttempts($clientId)
    {
        return PasswordAttempt::where('client_id', $clientId)
            ->where('successful', false)
            ->where('attempt_time', '>=', Carbon::now()->subMinutes(30))
            ->where('locked_until', null)
            ->count();
    }
    
    /**
     * Reset failed attempts for a user
     */
    private function resetFailedAttempts($clientId)
    {
        PasswordAttempt::where('client_id', $clientId)
            ->where('successful', false)
            ->update(['successful' => true]);
    }
    
    /**
     * Lock a user account for password attempts
     */
    private function lockUserAccount($clientId)
    {
        $lockUntil = Carbon::now()->addMinutes(30);
        
        PasswordAttempt::create([
            'client_id' => $clientId,
            'attempt_time' => Carbon::now(),
            'successful' => false,
            'locked_until' => $lockUntil,
            'is_admin_locked' => 1
        ]);
         auth::guard('user')->logout();
        return $lockUntil;
    }
    
    /**
     * Check if a user account is locked and until when
     */
    private function getUserLockoutTime($clientId)
    {
        $lockRecord = PasswordAttempt::where('client_id', $clientId)
            ->where('locked_until', '>', Carbon::now())
            ->orderBy('locked_until', 'desc')
            ->first();
            
        return $lockRecord ? $lockRecord->locked_until : null;
    }

    public function getLogout(){
        auth()->guard('user')->logout();
        return redirect()->route('client_login');
    }



    public function register(Request $request)
    {
        // Fetch states for the dropdown
        $states = DB::table('state')->where('status', 1)->orderBy('negeri_code', 'asc')->get();
        $districts = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
        $accountTypes = DB::table('account_types')->get();
        
        if ($request->isMethod('post')) {
            try {
                // Validate the request
                $this->validate($request, [
                    'accountType'       => 'required',
                    'email' => [
                        'required',
                        'email',
                        function ($attribute, $value, $fail) {
                            $existsInClientRegister = DB::table('client_register')->where('email', $value)->exists();
                            $existsInClients = DB::table('clients')->where('email', $value)->exists();
    
                            if ($existsInClientRegister || $existsInClients) {
                                $fail('This email is already registered. Please use a different email.');
                            }
                        },
                    ],
                    'password'          => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
                    'setPassword'       => 'required|min:8|same:password',
                    'userName'          => 'required|string|max:255',
                    'idCardNumber'      => 'required|string|max:50',
                    'registeredAddress' => 'required|string|max:255',
                    'postalCode'        => 'required|string|max:10',
                    'state'             => 'required',  
                    'district'          => 'required',  
                    'city'              => 'required|string|max:255',
                    'mobileNumber'      => 'required|string|min:10|unique:client_register,mobileNumber',
                    'landline'          => 'string|min:10|unique:client_register,landline',
                    'securityQuestion1' => 'required',  
                    'securityAnswers1'  => 'required|string|max:255',
                    'securityQuestions2'=> 'required',  
                    'securityAnswers2'  => 'required|string|max:255',
                    'terms'             => 'required|accepted',
                    'g-recaptcha-response' => 'required'
                ],
                [    
                    'accountType.required'       => __('app.accountType_required'),
                    'email.required'             => __('app.email_required'),
                    'email.email'                => __('app.email_email'),
                    'email.unique'               => __('app.email_unique'),
                    'password.required'          => __('app.password_required'),
                    'password.regex'             => __('app.password_format'),
                    'password.min'               => __('app.password_min'),
                    'setPassword.required'       => __('app.setPassword_required'),
                    'setPassword.min'            => __('app.setPassword_min'),
                    'setPassword.same'           => __('app.setPassword_same'),
                    'userName.required'          => __('app.userName_required'),
                    'userName.string'            => __('app.userName_string'),
                    'userName.max'               => __('app.userName_max'),
                    'idCardNumber.required'      => __('app.idCardNumber_required'),
                    'idCardNumber.string'        => __('app.idCardNumber_string'),
                    'idCardNumber.max'           => __('app.idCardNumber_max'),
                    'registeredAddress.required' => __('app.registeredAddress_required'),
                    'registeredAddress.string'   => __('app.registeredAddress_string'),
                    'registeredAddress.max'      => __('app.registeredAddress_max'),
                    'postalCode.required'        => __('app.postalCode_required'),
                    'postalCode.string'          => __('app.postalCode_string'),
                    'postalCode.max'             => __('app.postalCode_max'),
                    'state.required'             => __('app.state_required'),
                    'district.required'          => __('app.district_required'),
                    'city.required'              => __('app.city_required'),
                    'city.string'                => __('app.city_string'),
                    'city.max'                   => __('app.city_max'),
                    'mobileNumber.required'      => __('app.mobileNumber_required'),
                    'mobileNumber.string'        => __('app.mobileNumber_string'),
                    'mobileNumber.max'           => __('app.mobileNumber_max'),
                    'mobileNumber.unique'        => __('app.mobileNumber_unique'),
                    'landline.required'          => __('app.landline_required'),
                    'landline.string'            => __('app.landline_string'),
                    'landline.max'               => __('app.landline_max'),
                    'landline.unique'            => __('app.landline_unique'),
                    'securityQuestion1.required' => __('app.securityQuestion1_required'),
                    'securityAnswers1.required'  => __('app.securityAnswers1_required'),
                    'securityAnswers1.string'    => __('app.securityAnswers1_string'),
                    'securityAnswers1.max'       => __('app.securityAnswers1_max'),
                    'securityQuestions2.required'=> __('app.securityQuestions2_required'),
                    'securityAnswers2.required'  => __('app.securityAnswers2_required'),
                    'securityAnswers2.string'    => __('app.securityAnswers2_string'),
                    'securityAnswers2.max'       => __('app.securityAnswers2_max'),
                    'terms.required'             => __('app.terms_required'),
                    'terms.accepted'             => __('app.terms_accepted'),
                ]);
                
                // ADD RECAPTCHA VERIFICATION HERE
                // $recaptchaResponse = $request->input('g-recaptcha-response');
                // $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');
                
                
                // $googleResponse = \Illuminate\Support\Facades\Http::asForm()('https://www.google.com/recaptcha/api/siteverify', [
                //     'secret' => $recaptchaSecret,
                //     'response' => $recaptchaResponse,
                //     'remoteip' => $request->ip(),
                // ])->json();
         
                // if (empty($googleResponse['success']) || $googleResponse['success'] !== true) {
                //     $errorMessage = isset($googleResponse['error-codes'])
                //         ? implode(', ', $googleResponse['error-codes'])
                //         : 'Please complete the reCAPTCHA verification.';
    
                //     return response()->json([
                //         'success' => false,
                //         'errors' => ['g-recaptcha-response' => [$errorMessage]],
                //     ], 422);
                // }
                
                // Extract state data
                $stateData = DB::table('state')->where('idnegeri', $request->state)->where('status', 1)->first();
                $districtData = DB::table('district')->where('iddaerah', $request->district)->where('stat', 1)->first();
                
                if (empty($stateData)) {
                    throw new \Exception('Invalid state input format. Expected ID|Name.');
                }
                $state_id = $stateData->idnegeri ?? '';
                $state_name = $stateData->negeri ?? '';
    
                if (empty($districtData)) {
                    throw new \Exception('Invalid district input format. Expected ID|Name.');
                }
                $district_id = $districtData->iddaerah ?? '';
                $district_name = $districtData->daerah ?? '';
    
                // Use database transaction to ensure data consistency
                DB::beginTransaction();
                
                try {
                    // Insert into the clients table
                    $client = Client::create([
                        'name'        => $request->userName,
                        'password'    => bcrypt($request->password),
                        'email'       => $request->email,
                        'address1'    => $request->registeredAddress,
                        'state'       => $state_name,
                        'postal_code' => $request->postalCode,
                    ]);
    
                    // Insert into the client_register table
                    ClientRegisterModel::create([
                        'client_id'         => $client->uuid,
                        'accountType'       => $request->accountType,
                        'email'             => $request->email,
                        'password'          => bcrypt($request->password),
                        'setPassword'       => bcrypt($request->setPassword),
                        'userName'          => $request->userName,
                        'idCardNumber'      => $request->idCardNumber,
                        'registeredAddress' => $request->registeredAddress,
                        'postalCode'        => $request->postalCode,
                        'state_id'          => $state_id,
                        'state'             => $state_name,
                        'district_id'       => $district_id,
                        'district'          => $district_name,
                        'city'              => $request->city,
                        'mobileNumber'      => $request->mobileNumber,
                        'landline'          => $request->landline,
                        'securityQuestion1' => $request->securityQuestion1,
                        'securityAnswers1'  => $request->securityAnswers1,
                        'securityQuestions2'=> $request->securityQuestions2,
                        'securityAnswers2'  => $request->securityAnswers2,
                        'terms'             => $request->has('terms') ? 1 : 0,
                    ]);
                    
                    
                    $otpRecord = OtpVerification::generateOtp($request->email, 'registration');
                    
                    $user_client = ClientUser::where('uuid', $client->uuid)->first();
                    
                    
                    if ($user_client) {
                        // Send OTP notification (same pattern as your existing notifications)
                        $user_client->notify(new OtpVerificationNotification($otpRecord->otp, $request->userName));
                    } else {
                        // Fallback: Create temporary user if ClientUser doesn't exist yet
                        $tempUser = new TempUser($request->email, $request->userName);
                        $tempUser->notify(new OtpVerificationNotification($otpRecord->otp, $request->userName));
                    }
                    
                    // Commit the transaction
                    DB::commit();
                    
                    // Send welcome email
                    // Mail::to($request->email)->send(new WelcomeEmail($request->userName));
    
                    // Return JSON success response
                    return response()->json([
                        'success' => true,
                        'message' => 'Registration successful! A welcome email has been sent.',
                    ]);
                    
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
                
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->validator->errors(),
                ], 422);
            } catch (\Exception $e) {
                Log::error('Registration error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'An unexpected error occurred. Please try again later.',
                ], 500);
            }
        }
        
        // This code should ONLY run for GET requests
        $primaryQuestions = DB::table('security_questions')
            ->where('question_type', 'primary')
            ->where('status', 1)
            ->get();
            
        $secondaryQuestions = DB::table('security_questions')
            ->where('question_type', 'secondary')
            ->where('status', 1)
            ->get();
        
        // Return the registration view for GET requests
        return view('clientarea.auth.register', compact('states', 'districts', 'accountTypes', 'primaryQuestions', 'secondaryQuestions'));
    }
    
    public function validateField(Request $request)
    {
        // Extract field name and value
        $field = $request->input('field');
        $value = $request->input('value');

        // Validation rules for each field
        $rules = [
            'email' => [
                            'email',
                            function ($attribute, $value, $fail) {
                                $existsInClientRegister = DB::table('client_register')->where('email', $value)->exists();
                                $existsInClients = DB::table('clients')->where('email', $value)->exists();

                                if ($existsInClientRegister || $existsInClients) {
                                    $fail("This email is already registered.");
                                }
                            },
                        ],
            'userName' => 'string|max:255|unique:client_register,userName',
            'mobileNumber' => 'string|max:15|unique:client_register,mobileNumber',
            'landline' => 'string|max:15|unique:client_register,landline',
        ];

        // Ensure the field has a validation rule
        if (!isset($rules[$field])) {
            return response()->json(['valid' => false, 'message' => 'Invalid field name.'], 400);
        }

        // Validate the specific field
        $validator = Validator::make([$field => $value], [$field => $rules[$field]]);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'message' => $validator->errors()->first($field),
            ]);
        }

        return response()->json(['valid' => true]);
    }
    
    
    
    
   public function showOtpVerification(Request $request)
    {
        try {
            $email = $request->query('email');
            
            // Validate email parameter
            if (!$email) {
                \Log::warning('OTP verification accessed without email parameter');
                return redirect()->route('register')->with('error', 'Invalid request. Please register again.');
            }
    
            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                \Log::warning('Invalid email format in OTP verification', ['email' => $email]);
                return redirect()->route('register')->with('error', 'Invalid email format.');
            }
            
            // Check if user exists but not verified
            $clientRegister = ClientRegisterModel::where('email', $email)
                ->where('is_email_verified', false)
                ->first();
            
            if (!$clientRegister) {
                \Log::warning('OTP verification attempted for non-existent or already verified user', [
                    'email' => $email
                ]);
                
                // Check if user is already verified
                $verifiedUser = ClientRegisterModel::where('email', $email)
                    ->where('is_email_verified', true)
                    ->first();
                    
                if ($verifiedUser) {
                    return redirect()->route('client_login')->with('success', 'Your email is already verified. You can login now.');
                }
                
                return redirect()->route('register')->with('error', 'User not found. Please register again.');
            }
    
            // Check if there's a valid OTP for this email
            $latestOtp = OtpVerification::where('email', $email)
                ->where('type', 'registration')
                ->where('is_verified', false)
                ->where('expires_at', '>', now())
                ->orderBy('created_at', 'desc')
                ->first();
    
            if (!$latestOtp) {
                \Log::info('No valid OTP found, generating new one', ['email' => $email]);
                
                // Generate new OTP if none exists or all are expired
                $otpRecord = OtpVerification::generateOtp($email, 'registration');
                
                // Send OTP using the same pattern as registration
                $user_client = ClientUser::where('uuid', $clientRegister->client_id)->first();
                
                if ($user_client) {
                    $user_client->notify(new OtpVerificationNotification($otpRecord->otp, $clientRegister->userName));
                } else {
                    // Fallback to temporary user
                    $tempUser = new TempUser($email, $clientRegister->userName);
                    $tempUser->notify(new OtpVerificationNotification($otpRecord->otp, $clientRegister->userName));
                }
                
                // Update latest OTP reference
                $latestOtp = $otpRecord;
                
                \Log::info('New OTP generated and sent', [
                    'email' => $email,
                    'client_id' => $clientRegister->client_id
                ]);
            }
    
            // Calculate remaining time properly - THIS IS THE FIX
            $remainingTime = null;
            $remainingSeconds = 0; // Default to 0 instead of null
            
            if ($latestOtp && $latestOtp->expires_at > now()) {
                $expiresAt = \Carbon\Carbon::parse($latestOtp->expires_at);
                $now = now();
                
                // FIX: Use diffInSeconds with $absolute = false to get proper remaining time
                // Or better yet, use Carbon's built-in methods for future dates
                if ($expiresAt->isFuture()) {
                    $remainingSeconds = max(0, strtotime($latestOtp->expires_at) - time());
                    
                    // If still negative (shouldn't happen), use absolute value
                    if ($remainingSeconds < 0) {
                        $remainingSeconds = abs($remainingSeconds);
                    }
                    
                    // Convert to minutes and seconds for display
                    if ($remainingSeconds > 60) {
                        $minutes = floor($remainingSeconds / 60);
                        $seconds = $remainingSeconds % 60;
                        
                        if ($seconds > 0) {
                            $remainingTime = $minutes . ' minutes ' . $seconds . ' seconds';
                        } else {
                            $remainingTime = $minutes . ' minutes';
                        }
                    } else {
                        $remainingTime = $remainingSeconds . ' seconds';
                    }
                } else {
                    // OTP has expired
                    $remainingSeconds = 0;
                }
            }
    
            \Log::info('OTP verification page accessed', [
                'email' => $email,
                'user_name' => $clientRegister->userName,
                'remaining_time' => $remainingTime,
                'remaining_seconds' => $remainingSeconds,
                'otp_expires_at' => $latestOtp ? $latestOtp->expires_at : 'no_otp',
                'current_time' => now()->toDateTimeString()
            ]);
            
            return view('clientarea.auth.otp-verification', compact('email', 'clientRegister', 'remainingTime', 'remainingSeconds'));
            
        } catch (\Exception $e) {
            \Log::error('Show OTP Verification Error: ', [
                'message' => $e->getMessage(),
                'email' => $request->query('email') ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('register')->with('error', 'An error occurred. Please try registering again.');
        }
    }
    

    
    
    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|digits:6',
            ]);
    
            $email = $request->email;
            $otp = $request->otp;
    
            // Find the OTP record
            $otpRecord = OtpVerification::where('email', $email)
                ->where('otp', $otp)
                ->where('type', 'registration')
                ->where('is_verified', false)
                ->where('expires_at', '>', now())
                ->first();
    
            if (!$otpRecord) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired OTP. Please try again.'
                ], 422);
            }
    
            // Mark OTP as verified
            $otpRecord->update([
                'is_verified' => true,
                'verified_at' => now()
            ]);
    
            // **IMPORTANT: Update ClientRegisterModel as well**
            $clientRegister = ClientRegisterModel::where('email', $email)->first();
            if ($clientRegister) {
                $clientRegister->update([
                    'is_email_verified' => true,
                    'email_verified_at' => now()
                ]);
            }
    
            \Log::info('OTP verified successfully', [
                'email' => $email,
                'client_register_updated' => $clientRegister ? 'yes' : 'no'
            ]);
            
                try {
                    // Mail::to($email)->send(new EmailVerifiedConfirmation($clientRegister->userName));
                     Mail::to($request->email)->send(new WelcomeEmail($clientRegister->userName));
                } catch (\Exception $e) {
                    \Log::warning('Failed to send email verification confirmation', [
                        'email' => $email,
                        'error' => $e->getMessage()
                    ]);
                    // Don't fail the verification if email sending fails
                }
    
            return response()->json([
                'success' => true,
                'message' => 'Emel berjaya disahkan',
                'redirect_to_login' => true
            ]);
            
    
        } catch (\Exception $e) {
            \Log::error('OTP Verification Error: ', [
                'message' => $e->getMessage(),
                'email' => $request->email ?? 'unknown'
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'Verification failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Resend OTP for email verification
     */
    public function resendOtp(Request $request)
    {
        try {
            // Validate the request
            $this->validate($request, [
                'email' => 'required|email',
            ], [
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
            ]);
    
            $email = $request->email;
    
            // Check if user exists and is not verified
            $clientRegister = ClientRegisterModel::where('email', $email)
                ->where('is_email_verified', false)
                ->first();
    
            if (!$clientRegister) {
                \Log::warning('OTP resend attempted for non-existent or already verified user', [
                    'email' => $email
                ]);
    
                // Check if user is already verified
                $verifiedUser = ClientRegisterModel::where('email', $email)
                    ->where('is_email_verified', true)
                    ->first();
    
                if ($verifiedUser) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your email is already verified. You can login now.'
                    ], 400);
                }
    
                return response()->json([
                    'success' => false,
                    'message' => 'User not found. Please register again.'
                ], 404);
            }
    
            // Check for recent OTP requests to prevent spam
            $recentOtp = OtpVerification::where('email', $email)
                ->where('type', 'registration')
                ->where('created_at', '>', now()->subMinutes(1)) // 1 minute cooldown
                ->first();
    
            if ($recentOtp) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please wait at least 1 minute before requesting a new code.'
                ], 429);
            }
    
            // Invalidate existing OTPs for this email
            OtpVerification::where('email', $email)
                ->where('type', 'registration')
                ->where('is_verified', false)
                ->update(['is_verified' => true]);
    
            // Generate new OTP
            $otpRecord = OtpVerification::generateOtp($email, 'registration');
    
            // Send OTP using the same pattern as registration
            $user_client = ClientUser::where('uuid', $clientRegister->client_id)->first();
    
            if ($user_client) {
                $user_client->notify(new OtpVerificationNotification($otpRecord->otp, $clientRegister->userName));
            } else {
                // Fallback to temporary user
                $tempUser = new TempUser($email, $clientRegister->userName);
                $tempUser->notify(new OtpVerificationNotification($otpRecord->otp, $clientRegister->userName));
            }
    
            \Log::info('OTP resent successfully', [
                'email' => $email,
                'user_name' => $clientRegister->userName,
                'client_id' => $clientRegister->client_id
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'A new verification code has been sent to your email address.'
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors(),
                'message' => 'Please check your input and try again.'
            ], 422);
    
        } catch (\Exception $e) {
            \Log::error('OTP resend error', [
                'message' => $e->getMessage(),
                'email' => $request->email ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the code. Please try again.'
            ], 500);
        }
    }



}









