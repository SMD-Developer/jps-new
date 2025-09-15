<?php

namespace App\Http\Controllers\ClientArea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientRegisterModel;
use App\Models\PasswordAttempt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class UpdateProfileController extends Controller
{

    public function edit_profile($id=null)
    {
        // dd('sdfghjk', $id);
        $accountTypes = DB::table('account_types')->get();
        $districts = DB::table('district')->get();
        $states = DB::table('state')->get();
    // dd('sdfghjk', $id);
        $client = ClientRegisterModel::whereClientId($id)
        ->join('account_types', 'client_register.accountType', '=', 'account_types.id')
        ->select('client_register.*', 'account_types.name as account_type_name')
        ->first();
        // dd('sdfghjk', $client);
        return view('clientarea.crud.update_profile', compact('client', 'states', 'districts', 'accountTypes'));
    }

       public function update_profile(Request $request, int $id) 
{
    $clientRegister = ClientRegisterModel::findOrFail($id);

    if ($request->isMethod('put')) {
        try {
            $validated = $this->validate($request, [
                'userName'          => 'required|max:255',
                'idCardNumber'      => 'required|max:20',
                'postalCode'        => 'required|max:10',
                'registeredAddress' => 'required|max:500',
                'state'             => 'required',
                'district'          => 'required',
                'city'              => 'required|max:100',
                'mobileNumber'      => 'required|max:20',
                'landline'          => 'max:20',
                'photo'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if (!str_contains($request->state, '|') || !str_contains($request->district, '|')) {
                throw ValidationException::withMessages([
                    'state' => 'Invalid state format',
                    'district' => 'Invalid district format'
                ]);
            }

            [$state_id, $state_name] = explode('|', $request->state, 2);
            [$district_id, $district_name] = explode('|', $request->district, 2);

            // Update client_register table
            $registerData = [
                'userName'          => $request->userName,
                'idCardNumber'      => $request->idCardNumber,
                'postalCode'        => $request->postalCode,
                'registeredAddress' => $request->registeredAddress,
                'state_id'          => $state_id,
                'state'             => $state_name,
                'district_id'       => $district_id,
                'district'          => $district_name,
                'city'              => $request->city,
                'mobileNumber'      => $request->mobileNumber,
                'landline'          => $request->landline,
            ];

            $clientRegister->update($registerData);

            // Also update name, address, state and postal_code in clients table
            $client = Client::where('uuid', $clientRegister->client_id)->first();
            if ($client) {
                $client->update([
                    'name'        => $request->userName,
                    'address1'    => $request->registeredAddress,
                    'state'       => $state_name,
                    'postal_code' => $request->postalCode,
                ]);

                // Update photo if provided
                if ($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $filename = strtolower(Str::random(50) . '.' . $file->getClientOriginalExtension());
                    $file->move(config('app.uploads_path').'client_images', $filename);

                    // Delete old photo if exists
                    if ($client->photo) {
                        File::delete(config('app.uploads_path').'client_images/'.$client->photo);
                    }

                    $client->photo = $filename;
                    $client->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => trans('app.profile_updated_successfully'),
                'data'    => $clientRegister,
                'photo_url' => ($client && $client->photo)
                    ? url('assets/images/uploads/client_images/'.$client->photo)
                    : asset('uploads/defaultavatar.png')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Profile Update Error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => trans('app.unexpected_error'),
            ], 500);
        }
    }

    return redirect()->route('edit_profile', $id);
}
    
    //  public function Settings($id)
    // {
    //     $title = __("app.change_password");  
    //     $client = ClientRegisterModel::whereClientId($id)
    //     ->join('account_types', 'client_register.accountType', '=', 'account_types.id')
    //     ->select('client_register.*', 'account_types.name as account_type_name')
    //     ->first();
    //     // dd( $client);
    //      return view('clientarea.crud.settings', compact('title','client'));
    // } 
    // public function changePassword(Request $request, $uuid)
    // {
    //     // dd($request->all(), $uuid);
    //     $validator = Validator::make($request->all(), [
    //         'old_password' => 'required',
    //         'new_password' => 'required|string|min:8|confirmed',
    //     ]);
        
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
    //     // dd('Validation passed');
    //     // Get client from `clients` table (used for login)
    //     $client = Client::where('uuid', $uuid)->first();
    //     // dd($client);
    //     if (!$client) {
    //         return response()->json(['errors' => ['client' => ['Client not found.']]], 422);
    //     }
    
    //     // Check old password using the hashed password from the clients table
    //     if (!Hash::check($request->old_password, $client->password)) {
    //         return response()->json(['errors' => ['old_password' => ['Old password is incorrect.']]], 422);
    //     }
    
    //     $client->password = Hash::make($request->new_password);
    //     $client->save();
    //     // Update password in `client_register` table as well
    //     return response()->json(['message' => 'Password updated successfully.']);
    // }
    
    
    public function Settings($id)
    {
        $title = __("app.change_password");
        
        $client = ClientRegisterModel::whereClientId($id)
            ->join('account_types', 'client_register.accountType', '=', 'account_types.id')
            ->select('client_register.*', 'account_types.name as account_type_name')
            ->first();
        
        $lockedUntil = $this->getUserLockoutTime($id);
        $isLocked = false;
        $remainingTime = null;
        
        if ($lockedUntil && $lockedUntil > Carbon::now()) {
            $isLocked = true;
            $remainingTime = Carbon::now()->diffInMinutes($lockedUntil) + 1; 
        }
        
        return view('clientarea.crud.settings', compact('title', 'client', 'isLocked', 'remainingTime'));
    } 


    public function changePassword(Request $request, $uuid)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%])[^\s]{8,20}$/',
                'different:old_password'
            ],
            'new_password_confirmation' => 'required|same:new_password',
        ], [
            'new_password.regex' => __('app.password_validation_message'),
            'new_password.different' => __('app.new_password_must_be_different')
        ]);
    
        $lockedUntil = $this->getUserLockoutTime($uuid);
        if ($lockedUntil && $lockedUntil > Carbon::now()) {
            $remainingTime = Carbon::now()->diffInMinutes($lockedUntil) + 1;
            return response()->json([
                'success' => false,
                'errors' => [
                    'old_password' => [__('app.account_locked', ['minutes' => $remainingTime])]
                ]
            ], 422);
        }
        
        // $client = ClientRegisterModel::whereClientId($id)->first();
         $client = Client::where('uuid', $uuid)->first();
        if (!$client) {
            return response()->json([
                'success' => false,
                'errors' => ['general' => [__('app.user_not_found')]]
            ], 404);
        }
        
        if (!Hash::check($request->old_password, $client->password)) {
            $this->recordFailedAttempt($uuid);
            $attempts = $this->getFailedAttempts($uuid);
            $remainingAttempts = 5 - $attempts;
            
            if ($attempts >= 5) {
                $this->lockUserAccount($uuid);
                
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'old_password' => [__('account locked maximum attempt reached', ['minutes' => 30])]
                    ]
                ], 422);
            }
            
            return response()->json([
                'success' => false,
                'errors' => [
                    'old_password' => [
                        __('app.old_password_incorrect') . ' ' . 
                        __( $remainingAttempts . ' attempts remaining.')
                    ]
                ]
            ], 422);
        }
    
        $this->resetFailedAttempts($uuid);
        $client->password = Hash::make($request->new_password);
        $client->save();
        
        return response()->json([
            'success' => true,
            'message' => __('app.password_updated_successfully')
        ]);
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
         Auth::guard('user')->logout();
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
}
