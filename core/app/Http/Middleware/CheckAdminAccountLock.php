<?php namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PasswordAttempt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckAdminAccountLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $login = $request->input('login');
        $login_type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$login_type => $login]);

        $adminuser = User::where('email', $request->input('email'))->first();
        if ($adminuser) {
            $isLocked = PasswordAttempt::where('admin_id', $adminuser->uuid)
                ->where('is_admin_locked', true)
                ->exists();

            if ($isLocked) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => __('Your account is locked. Please contact the administrator to unlock it.'),
                        'action' => 'show_msg'
                    ], 422);
                }
                return redirect()->route('admin_login')
                    ->withErrors(['login' => __('app.account_blocked_contact_admin')]);
            }
        }

        return $next($request);
    }
}