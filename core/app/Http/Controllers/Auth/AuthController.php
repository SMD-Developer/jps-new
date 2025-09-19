<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\PasswordAttempt;
use Carbon\Carbon;

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
		protected $loginPath = '/login';
	    use AuthenticatesUsers;

		public function __construct(){
			$this->middleware('guest', ['except' => 'getLogout']);
		}
    public function validator(array $data){
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data){
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
// 	public function postLogin(Request $request){
// 		// get our login input
// 		$login = $request->input('login');
// 		// check login field
// 		$login_type = filter_var( $login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
// 		// merge our login field into the request with either email or username as key
// 		$request->merge([ $login_type => $login ]);
// 		// let's validate and set our credentials
// 		if ($login_type === 'email'){
// 			$this->validate($request, [
// 				'email'    => 'required|email',
// 				'password' => 'required',
// 			]);
// 			$credentials = $request->only( 'email', 'password' );
// 		} else {
// 			$this->validate($request, [
// 				'username' => 'required',
// 				'password' => 'required',
// 			]);
// 			$credentials = $request->only( 'username', 'password' );
// 		}
// 		if (auth('admin')->attempt($credentials)){
//              $user = auth('admin')->user(); // Get the logged-in user
// // dd($user);
//         // Redirect based on role
//         $redirect_url = route('home'); // Default route
//         if ($user->username == 'admin') {
//             $redirect_url = route('home');
//         } elseif ($user->username == 'adminstaff') {
//             $redirect_url = route('home_admin_staff');
//         } elseif ($user->username == 'finance') {
//             $redirect_url = route('home-finance');
//         } elseif ($user->username == 'approver') {
//             $redirect_url = route('approver-home');
//         } elseif ($user->username == 'reviewer') {
//             $redirect_url = route('home-reviewer');
//         } elseif ($user->username == 'applicationapprover') {
//             $redirect_url = route('home_adminapprover');
//         }
//  \Log::info("User {$user->role_id} logged in with role: {$user->username}. Redirecting to: {$redirect_url}");
//         return response()->json([
//             'success' => true,
//             'message' => 'Login successful!',
//             'action' => 'redirect',
//             'redirect_url' => $redirect_url,
//         ]);
//     }
		
//         return response()->json([
//             'success' => false,
//             'message' => 'Email & Password does not match with our record.',
//         ],401);
// 	}



    public function postLogin(Request $request)
    {
        $login = $request->input('login');
        $login_type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$login_type => $login]);
        
        
        if (empty($login) && empty($password)) {
            return response()->json([
                'success' => false,
                'message' => 'Emel dan kata laluan tidak boleh dibiarkan kosong',
            ], 422);
        }
        
        
        $messages = [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'username.required' => 'Emel dan kata laluan tidak boleh dibiarkan kosong',
            'password.required' => 'Kata laluan perlu diisi.',
        ];
        
        if ($login_type === 'email') {
            $this->validate($request, [
                'email'    => 'required|email',
                'password' => 'required',
            ], $messages);
            $credentials = $request->only('email', 'password');
            $identifier = $request->email;
        } else {
            $this->validate($request, [
                'username' => 'required',
                'password' => 'required',
            ], $messages);
            $credentials = $request->only('username', 'password');
            $identifier = $request->username;
        }

        $user = User::where($login_type, $identifier)->first();
        
        if ($user) {
            $lockedUntil = $this->getAdminLockoutTime($user->uuid);
            if ($lockedUntil && $lockedUntil > Carbon::now()) {
                $remainingTime = Carbon::now()->diffInMinutes($lockedUntil) + 1;
                return response()->json([
                    'success' => false,
                    'message' => __('app.account_locked', ['minutes' => $remainingTime]),
                ], 401);
            }
        }
        
        
         // ADD THIS CHECK FOR FORCE PASSWORD RESET - RIGHT HERE
            if ($user->force_password_reset) {
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
        
        
        

        if (auth('admin')->attempt($credentials)) {
            $user = auth('admin')->user();
            
            // Reset failed attempts since login was successful
            $this->resetAdminFailedAttempts($user->uuid);
            
            // Set redirect URL based on user type
            $redirectUrls = [
                '5c7f11d2-7091-4d10-aaeb-a9b4e3b76a76' => route('home'),
                '9e032984-8ef0-4e00-b7b9-439679a4d1aa' => route('home_admin_staff'),
                '9e032970-5f48-4d2b-b88e-abb9da79140f' => route('home-finance'),
                '27f41653-a968-4885-8000-7aaf4efc385d' => route('approver-home'),
                '9e032769-7342-46ba-b7c9-4f6f70570c98' => route('home-reviewer'),
                '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d' => route('home_adminapprover'),
            ];
            
            $redirect_url = $redirectUrls[$user->role_id] ?? route('home');
            
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'action' => 'redirect',
                'redirect_url' => $redirect_url,
            ]);
        }
        
        if ($user) {
            $this->recordAdminFailedAttempt($user->uuid);
            $attempts = $this->getAdminFailedAttempts($user->uuid);
            $remainingAttempts = 5 - $attempts;
            
            if ($attempts >= 5) {
                $this->lockAdminAccount($user->uuid);
                return response()->json([
                    'success' => false,
                    'message' => __('account locked maximum attempt reached', ['minutes' => 30]),
                ], 401);
            }
            
            // return response()->json([
            //     'success' => false,
            //     'message' => __('auth.failed') . ' ' . 
            //                 __($remainingAttempts . ' percubaan yang tinggal.'),
            // ], 401);
            return response()->json([
                'success' => false,
                'message' => "E-mel dan kata laluan tidak sepadan. Klik Lupa kata laluan jika anda lupa kata laluan. Anda mempunyai {$remainingAttempts} cubaan lagi.",
            ], 401);
        }
        
            // $sessionKey = 'failed_login_attempts_' . $request->ip();
            // $attempts = session($sessionKey, 0) + 1;
            // session([$sessionKey => $attempts]);
            
            // $remainingAttempts = 5 - $attempts;
            
            // if ($attempts >= 5) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Akaun dikunci kerana terlalu banyak percubaan yang gagal. Cuba lagi dalam 30 minit.',
            //     ], 401);
            // }
        
        // User not found case
        return response()->json([
            'success' => false,
            'message' => "E-mel dan kata laluan tidak sepadan. Klik Lupa kata laluan jika anda lupa kata laluan. Anda mempunyai {$remainingAttempts} cubaan lagi.",
        ], 401);
    }
    


    
    
    public function getLogout(){
     auth()->guard('admin')->logout();
     return redirect()->route('admin_login');
    }
 
 
    private function recordAdminFailedAttempt($uuid)
    {
        PasswordAttempt::create([
            'admin_id' => $uuid,
            'attempt_time' => Carbon::now(),
            'successful' => false
        ]);
    }

    /**
     * Get number of recent failed attempts for admin (last 30 minutes)
     */
    private function getAdminFailedAttempts($uuid)
    {
        return PasswordAttempt::where('admin_id', $uuid)
            ->where('successful', false)
            ->where('attempt_time', '>=', Carbon::now()->subMinutes(30))
            ->where('locked_until', null)
            ->count();
    }

    /**
     * Reset failed attempts for an admin
     */
    private function resetAdminFailedAttempts($uuid)
    {
        PasswordAttempt::where('admin_id', $uuid)
            ->where('successful', false)
            ->update(['successful' => true]);
    }

    /**
     * Lock an admin account for password attempts
     */
    private function lockAdminAccount($uuid)
    {
        $lockUntil = Carbon::now()->addMinutes(1);
        
        PasswordAttempt::create([
            'admin_id' => $uuid,
            'attempt_time' => Carbon::now(),
            'successful' => false,
            'locked_until' => $lockUntil,
            'is_admin_locked' => 1
        ]);
        
        auth('admin')->logout();
        return $lockUntil;
    }

    /**
     * Check if an admin account is locked and until when
     */
    private function getAdminLockoutTime($uuid)
    {
        $lockRecord = PasswordAttempt::where('admin_id', $uuid)
            ->where('locked_until', '>', Carbon::now())
            ->orderBy('locked_until', 'desc')
            ->first();
            
        return $lockRecord ? $lockRecord->locked_until : null;
    }
}
