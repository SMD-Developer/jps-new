<?php namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PasswordAttempt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientRegisterModel;

class CheckAccountLock
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

        $client = ClientRegisterModel::where('email', $request->input('email'))->first();
        if ($client) {
            $isLocked = PasswordAttempt::where('client_id', $client->client_id)
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
                return redirect()->route('client_login')
                    ->withErrors(['login' => __('app.account_blocked_contact_admin')]);
            }
        }

        return $next($request);
    }
}