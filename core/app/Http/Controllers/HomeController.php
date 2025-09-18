<?php namespace App\Http\Controllers;

use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
// use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
use Illuminate\View\View;
use DB;
use App\Models\Application;
use App\Models\ClaimContribution;
use App\Models\Payment;
use App\Notifications\NewApplicationSent;
use App\Notifications\UserApplicationStatusNotification;
use App\Notifications\UserApplicationRejectionNotification;
use App\Notifications\AccountUnblockedNotification;
use App\Notifications\AdminAccountUnblockedNotification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClientRegisterModel;
use App\Models\PasswordAttempt;
use App\Models\LandMeasurement;
use App\Models\LandCategory;
use App\Models\Client as ClientUser ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use App\Models\ApplicationLog;
use Illuminate\Support\Facades\Log;
use App\Traits\TracksApplicationViews;
use App\Traits\LogsActivity;
use App\Models\ActivityLog;

class HomeController extends Controller {
    use TracksApplicationViews;
    use LogsActivity;
    protected $invoice, $product, $client, $estimate, $payment, $expense;
    
    
    /**
     * Create a new controller instance.
     */
    public function __construct(Invoice $invoice, Product $product, Client $client, Estimate $estimate, Payment $payment, Expense $expense)
    {
        $this->invoice      = $invoice;
        $this->product      = $product;
        $this->client       = $client;
        $this->estimate     = $estimate;
        $this->payment      = $payment;
        $this->expense      = $expense;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return View
     */
    public function index()
    {
        $totalapplication = DB::table('applications')->count(); // Total applications
        $newapplication = DB::table('applications')->where('status', 'pending')->count(); 
        $monthapplication = DB::table('applications')
            ->whereMonth('created_at', date('m'))
            ->count(); 
        $approvedapplication = DB::table('applications')->where('status', 'approved')->count(); 
        $passed = DB::table('applications')->where('status', 'approved')->count();
        $rejected = DB::table('applications')->where('status', 'rejected')->count();
        
        $applicationsByDistrict = DB::table('applications')
            ->select('district', DB::raw('count(*) as total'))
            ->groupBy('district')
            ->get();
            
         $districtCounts = DB::table('applications')
            ->select('district', DB::raw('count(*) as count'))
            ->groupBy('district')
            ->get();
            
        $districts = [];
        foreach ($districtCounts as $item) {
            $districtInfo = DB::table('district')
                ->where('iddaerah', $item->district)
                ->first();
                
            if ($districtInfo) {
                $districts[] = [
                    'name' => $districtInfo->daerah,
                    'count' => $item->count
                ];
            }
        }
        
        return view('home', compact(
            'totalapplication', 
            'newapplication', 
            'monthapplication', 
            'approvedapplication', 
            'passed',
            'rejected',
            'applicationsByDistrict',
            'districts'
        ));
    }
    
    public function getDistricts($state_id)
    {
        $districts =DB::table('district')->where('idnegeri',$state_id)->where('stat',1)->orderBy('daerah_code','asc')->get();
        // Return districts as JSON
        return response()->json($districts);
    }
	public function getDivision($id)
    {
         $division=DB::table('division')->where('daerah_id',$id)->where('status',1)->orderBy('mukim_code','asc')->get();
        // Return districts as JSON
        return response()->json($division);
    }
    
   
    // public function applicationList(Request $request) {         
    //     $perPage = $request->input('per_page', 10);         
    //     $isAuthenticated = auth('admin')->check();                  
    //     $canAdminStaffViewApplication = auth('admin')->user()->hasPermission('applications.view-details');         
    //     $canAdminStaffEditApplication = auth('admin')->user()->hasPermission('applications.edit');                  
    //     $isAdminOrStaff = false;         
    //     if ($isAuthenticated) {             
    //         $roleId = auth('admin')->user()->role_id;             
    //         $isAdminOrStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');         
    //     }                  

    //     $query = Application::with(['state', 'landDistrict', 'landDivision', 'client']);                  

    //     if ($request->has('district') && $request->district) {             
    //         $query->where('land_district', $request->district);         
    //     }                  

    //     if ($request->has('division') && $request->division) {             
    //         $query->where('land_state', $request->division);         
    //     }                  

    //     if ($request->has('lot') && $request->lot) {             
    //         $query->where('land_lot', 'LIKE', '%' . $request->lot . '%');         
    //     }                  

    //     // Get the paginated results with activity tracking
    //     $list = $query->latest()
    //         ->paginate($perPage)
    //         ->appends($request->except('page'));

    //     // Get current user ID for highlighting
    //     $currentUserId = auth('admin')->id();

    //     // Get activity data for each application
    //     foreach ($list as $application) {
    //         // Get the most recent view and edit activities from application_views table
    //         $latestView = DB::table('application_views')
    //             ->where('application_id', $application->id)
    //             ->where('action_type', 'view')
    //             ->latest('viewed_at')
    //             ->first();

    //         $latestEdit = DB::table('application_views')
    //             ->where('application_id', $application->id)
    //             ->where('action_type', 'edit')
    //             ->latest('viewed_at')
    //             ->first();

    //         // Initialize activity data
    //         $application->latest_view_user = null;
    //         $application->latest_edit_user = null;
    //         $application->latest_view_date = null;
    //         $application->latest_edit_date = null;
    //         $application->viewed_by_current_user = false;
    //         $application->edited_by_current_user = false;

    //         if ($latestView) {
    //             $application->latest_view_user = $latestView->user_name;
    //             $application->latest_view_date = $latestView->viewed_at;
    //             $application->viewed_by_current_user = ($latestView->user_id == $currentUserId);
    //         }

    //         if ($latestEdit) {
    //             $application->latest_edit_user = $latestEdit->user_name;
    //             $application->latest_edit_date = $latestEdit->viewed_at;
    //             $application->edited_by_current_user = ($latestEdit->user_id == $currentUserId);
    //         }
    //     }

    //     $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();                  

    //     return view('listapplication', compact(             
    //         'list',              
    //         'district',              
    //         'perPage',              
    //         'isAdminOrStaff',              
    //         'canAdminStaffViewApplication',              
    //         'canAdminStaffEditApplication',
    //         'currentUserId'
    //     ));     
    // }
    
    
    public function applicationList(Request $request) {         
            $perPage = $request->input('per_page', 10);         
            $isAuthenticated = auth('admin')->check();                  
            $canAdminStaffViewApplication = auth('admin')->user()->hasPermission('applications.view-details');         
            $canAdminStaffEditApplication = auth('admin')->user()->hasPermission('applications.edit');                  
            $isAdminOrStaff = false;         
            if ($isAuthenticated) {             
                $roleId = auth('admin')->user()->role_id;             
                $isAdminOrStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');         
            }                  
            $query = Application::with(['state', 'landDistrict', 'landDivision', 'client']);                  
            
            if ($request->has('status') && $request->status && $request->status !== '') {             
                $query->where('status', $request->status);         
            }
            
            if ($request->has('district') && $request->district) {             
                $query->where('land_district', $request->district);         
            }                  
            
            if ($request->has('division') && $request->division) {             
                $query->where('land_state', $request->division);         
            }                  
            
            if ($request->has('lot') && $request->lot) {             
                $query->where('land_lot', 'LIKE', '%' . $request->lot . '%');         
            }                  
            

            $list = $query->latest()
                ->paginate($perPage)
                ->appends($request->except('page'));
            
            $currentUserId = auth('admin')->id();
            
    
            foreach ($list as $application) {
                $latestView = DB::table('application_views')
                    ->where('application_id', $application->id)
                    ->where('action_type', 'view')
                    ->latest('viewed_at')
                    ->first();
                $latestEdit = DB::table('application_views')
                    ->where('application_id', $application->id)
                    ->where('action_type', 'edit')
                    ->latest('viewed_at')
                    ->first();
                
                $application->latest_view_user = null;
                $application->latest_edit_user = null;
                $application->latest_view_date = null;
                $application->latest_edit_date = null;
                $application->viewed_by_current_user = false;
                $application->edited_by_current_user = false;
                
                if ($latestView) {
                    $application->latest_view_user = $latestView->user_name;
                    $application->latest_view_date = $latestView->viewed_at;
                    $application->viewed_by_current_user = ($latestView->user_id == $currentUserId);
                }
                
                if ($latestEdit) {
                    $application->latest_edit_user = $latestEdit->user_name;
                    $application->latest_edit_date = $latestEdit->viewed_at;
                    $application->edited_by_current_user = ($latestEdit->user_id == $currentUserId);
                }
            }
            
            $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();                  
            
            return view('listapplication', compact(             
                'list',              
                'district',              
                'perPage',              
                'isAdminOrStaff',              
                'canAdminStaffViewApplication',              
                'canAdminStaffEditApplication',
                'currentUserId'
            ));     
        }
    
     public function claimList(Request $request){
        $perPage = $request->input('per_page', 10);         
        $isAuthenticated = auth('admin')->check();                  
        $canAdminStaffViewApplication = auth('admin')->user()->hasPermission('applications.view-details');         
        $canAdminStaffEditClaimApplication = auth('admin')->user()->hasPermission('claim-contribution.edit');                  
        $isAdminOrStaff = false;         
        if ($isAuthenticated) {             
            $roleId = auth('admin')->user()->role_id;             
            $isAdminOrStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');         
        }                  

        $query = ClaimContribution::with(['state', 'landDistrict', 'landDivision', 'client']);                  

        if ($request->has('district') && $request->district) {             
            $query->where('land_district', $request->district);         
        }                  

        if ($request->has('division') && $request->division) {             
            $query->where('land_state', $request->division);         
        }                  

        if ($request->has('lot') && $request->lot) {             
            $query->where('land_lot', 'LIKE', '%' . $request->lot . '%');         
        }                  

        // Get the paginated results with activity tracking
        $list = $query->latest()
            ->paginate($perPage)
            ->appends($request->except('page'));

        // Get current user ID for highlighting
        $currentUserId = auth('admin')->id();

        $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get(); 
        return view('claim.claim-contribution-list', compact( 'list',              
            'district',              
            'perPage',              
            'isAdminOrStaff',              
            'canAdminStaffViewApplication',              
            'canAdminStaffEditClaimApplication',
            'currentUserId'));
    }
    
    
     public function claimView(Request $request, $id)
    {
        try {
            
            $isAuthenticated = auth('admin')->check();
            $isAdminStaff = false;
            if ($isAuthenticated) {
                // Get the role_id
                $roleId = auth('admin')->user()->role_id;
                $isAdminStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');
            }
            $claim = ClaimContribution::with(['state', 'landDistrict', 'landDivision', 'client'])
                ->findOrFail($id);
            
            $state = DB::table('state')->where('status', 1)->orderBy('negeri_code', 'asc')->get();
            $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
            $division = DB::table('division')->where('status', 1)->orderBy('mukim_code', 'asc')->get();
            $landMeasurement = DB::table('land_measurement_unit')->get();

            return view('claim.edit-claim-contribution', compact(
                'claim',
                'state',
                'district',
                'landMeasurement',
                'division',
                'isAdminStaff'
            ));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Claim not found or an error occurred.');
        }
    }
    
    
    // public function updateStatus(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'status' => 'required|in:pending,approve_payment_in_process,rejected,approve_paid'
    //     ]);
    
    //     $claim = DB::table('claim_contribution')->where('id', $id)->first();
    //     if (!$claim) {
    //         return response()->json(['message' => 'Claim not found'], 404);
    //     }
    
    //     DB::table('claim_contribution')
    //         ->where('id', $id)
    //         ->update(['status' => $request->status]);
    
    //     return response()->json(['message' => __('app.status_updated_successfully')]);
    // }
    
    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,approve_payment_in_process,rejected,approve_paid'
            ]);
    
            $claim = DB::table('claim_contribution')->where('id', $id)->first();
            if (!$claim) {
                return response()->json(['message' => 'Claim not found'], 404);
            }
    
            $oldData = (array) $claim;
            $oldStatus = $claim->status;
    
            DB::table('claim_contribution')
                ->where('id', $id)
                ->update(['status' => $request->status]);
    

            $updatedClaim = DB::table('claim_contribution')->where('id', $id)->first();
            $newData = (array) $updatedClaim;

            $changes = [];
            foreach ($newData as $key => $value) {
                if (array_key_exists($key, $oldData)) {
                    $oldValue = is_object($oldData[$key]) ? json_encode($oldData[$key]) : $oldData[$key];
                    $newValue = is_object($value) ? json_encode($value) : $value;
                    
                    if ($oldValue != $newValue) {
                        $changes[$key] = [
                            'old' => $oldValue,
                            'new' => $newValue
                        ];
                    }
                }
            }
    
            $admin = auth('admin')->user();
            $causerUsername = $admin ? $admin->username : 'System';
            $causerUuid = $admin ? $admin->uuid : null;
    
            ActivityLog::create([
                'log_name' => 'claim_contribution',
                'description' => 'Claim status updated by admin: ' . $causerUsername . ' from "' . $oldStatus . '" to "' . $request->status . '"',
                'event' => 'status_updated',
                'subject_type' => 'App\Models\ClaimContribution', // Adjust model name as needed
                'subject_id' => $id,
                'properties' => $changes, // This will contain all changed fields
                'causer_type' => $admin ? get_class($admin) : null,
                'causer_id' => $causerUuid,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            return response()->json(['message' => __('status updated successfully')]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log specific validation errors
            \Log::error('Validation Errors: ', $e->errors());
            
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Validation failed. Please check your inputs.'
            ], 422);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 500);
        }
    }


//     public function approverapplicationList(Request $request)
//   {
//         $perPage = $request->input('per_page', 10);
//         $canApproverViewApplicationDetails = auth('admin')->user()->hasPermission('applications.view-details');
//         $isAuthenticated = auth('admin')->check();
//         $isAdminOrStaff = false;
//         if ($isAuthenticated) {
//             // Get the role_id
//             $roleId = auth('admin')->user()->role_id;
//             $isAdminOrStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');
//         }
    
//         $list = Application::with(['state', 'landDistrict', 'landDivision', 'client'])
//             ->where('forwarded_by_admin_staff', 1)
//             ->latest()
//             ->paginate($perPage);
            
//         $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
        
//         return view('approver.approver_application_list', compact('list', 'district', 'perPage', 'isAdminOrStaff', 'canApproverViewApplicationDetails'));
//     }


   public function approverapplicationList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $canApproverViewApplicationDetails = auth('admin')->user()->hasPermission('applications.view-details');
        $isAuthenticated = auth('admin')->check();
        $isAdminOrStaff = false;
        if ($isAuthenticated) {
            // Get the role_id
            $roleId = auth('admin')->user()->role_id;
            $isAdminOrStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');
        }
    
        $query = Application::with(['state', 'landDistrict', 'landDivision', 'client'])
            ->where('forwarded_by_admin_staff', 1);
    
        // Add status filter
        if ($request->has('status') && $request->status && $request->status !== '') {             
            $query->where('status', $request->status);         
        }
        
        // Add district filter
        if ($request->has('district') && $request->district) {             
            $query->where('land_district', $request->district);         
        }
        
        // Add division filter
        if ($request->has('division') && $request->division) {             
            $query->where('land_state', $request->division);         
        }
        
        // Add lot filter
        if ($request->has('lot') && $request->lot) {             
            $query->where('land_lot', 'LIKE', '%' . $request->lot . '%');         
        }
    
        $list = $query->latest()
            ->paginate($perPage)
            ->appends($request->except('page'));
            
        $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
        
        return view('approver.approver_application_list', compact('list', 'district', 'perPage', 'isAdminOrStaff', 'canApproverViewApplicationDetails'));
    }




    public function searchApplications(Request $request)
    {
        $query = Application::query();
    
        $query->leftJoin('districts', 'applications.district', '=', 'districts.iddaerah')
        ->leftJoin('divisions', 'applications.land_state', '=', 'divisions.idmukim');
    
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('applications.applicant', 'like', '%' . $searchTerm . '%')
                ->orWhere('applications.land_lot', 'like', '%' . $searchTerm . '%')
                ->orWhere('applications.land_area', 'like', '%' . $searchTerm . '%')
                ->orWhere('districts.daerah', 'like', '%' . $searchTerm . '%')
                ->orWhere('divisions.mukim', 'like', '%' . $searchTerm . '%');
            });
        }
    
        if ($request->filled('district')) {
            $query->where('applications.district', $request->district);
        }
    
        if ($request->filled('division')) {
            $query->where('applications.land_state', $request->division);
        }
    
        // Filter by lot
        if ($request->filled('land_lot')) {
            $query->where('applications.land_lot', 'like', '%' . $request->land_lot . '%');
        }
    
        $query->select('applications.*');

        $list = $query->get();
    
        $district = District::all();
        
        $noResults = $list->isEmpty();
        
        return view('listapplication', compact('list', 'district', 'noResults'));
    }
    
     public function newApplication($id,Request $request){
        $application = DB::table('applications')->where('id', $id)->first();

        if (!$application) {
            abort(404, __('app.application_not_found'));
        }
        
        $this->trackApplicationAction($id, 'view', $request);
    
        // Fetch the state name based on the state ID
        $state = DB::table('state')->where('idnegeri', $application->state)->value('negeri');

        // Fetch the district name based on the district ID
        $district = DB::table('district')->where('iddaerah', $application->district)->value('daerah');
        $landDistrict = DB::table('district')->where('iddaerah', $application->land_district)->value('daerah');
        // Fetch the division name based on the division ID
       $division = DB::table('division')->where('idmukim', $application->land_state)->value('mukim');
       $landMeasurement = DB::table('land_measurement_unit')->get();
    
        return view('application.new_application', compact('application','state', 'district', 'landDistrict' ,'division', 'landMeasurement'));
    }
    
    // public function trackAction(Request $request)
    // {
    //     $validated = $request->validate([
    //         'application_id' => 'required|exists:applications,id',
    //         'action_type' => 'required|in:view,edit'
    //     ]);

    //     $this->trackApplicationAction(
    //         $validated['application_id'],
    //         $validated['action_type'],
    //         $request,
    //         'admin'
    //     );

    //     return response()->json(['success' => true]);
    // }
    
    
    protected function trackAction($applicationId, $actionType, $request, $userType = 'admin')
{
    $userId = Auth::id();
    $user = Auth::user();
    
    // Check if this user already performed this action on this application
    $existingAction = DB::table('application_views')
        ->where('application_id', $applicationId)
        ->where('user_id', $userId)
        ->where('action_type', $actionType)
        ->first();
        
    if (!$existingAction) {
        // Record the action
        DB::table('application_views')->insert([
            'application_id' => $applicationId,
            'user_id' => $userId,
            'user_type' => $userType,
            'user_name' => $user->name ?? 'default_name',
            'action_type' => $actionType,
            'viewed_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    } else {
        // Update the existing record
        DB::table('application_views')
            ->where('application_id', $applicationId)
            ->where('user_id', $userId)
            ->where('action_type', $actionType)
            ->update([
                'viewed_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'updated_at' => now()
            ]);
    }
}


   public function approvernewApplication($id){
   $application = DB::table('applications')->where('id',$id)->first();
         
	     if (!$application) {
        abort(404, __('app.application_not_found')); 
        }
        
        if ($application->forwarded_by_admin_staff != 1) {
            return redirect()->route('approver-application_list')
                ->with('error', __('Application not forwarded by admin'));
        }
         $state=DB::table('state')->where('status',1)->orderBy('negeri_code','asc')->get();
	     $district=DB::table('district')->where('stat',1)->orderBy('daerah_code','asc')->get();
	     $division=DB::table('division')->where('status',1)->orderBy('mukim_code','asc')->get();
         $landCategories = DB::table('land_category')->get();
         $landMeasurement = DB::table('land_measurement_unit')->get();

    return view('approver.approver_application_details', compact('application','state','district','division', 'landCategories', 'landMeasurement'));
}


    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $applications = Application::with(['client', 'landDistrict', 'landDivision'])
            ->where('land_lot', 'LIKE', "%{$search}%")
            ->latest()
            ->get();
    
    
        $applications->each(function($item) {
            $item->land_district_data = $item->landDistrict;
            $item->land_division_data = $item->landDivision;
        });
    
        return response()->json([
            'applications' => $applications
        ]);
    }
    public function updateApplication($id, Request $request){
         $application = DB::table('applications')->where('id',$id)->first();
         
	     if (!$application) {
        abort(404, __('app.application_not_found')); // Handle if the application doesn't exist
        }
        
         $this->trackApplicationAction($id, 'edit', $request);
         $state=DB::table('state')->where('status',1)->orderBy('negeri_code','asc')->get();
	     $district=DB::table('district')->where('stat',1)->orderBy('daerah_code','asc')->get();
	     $division=DB::table('division')->where('status',1)->orderBy('mukim_code','asc')->get();
         $landCategories = DB::table('land_category')->get();
         $landMeasurement = DB::table('land_measurement_unit')->get();
        return view('application.updateApplication',compact('application','state','district','division', 'landCategories' , 'landMeasurement'));
    }
    
    public function saveUpdatedApplication(Request $request, $id)
    {
        try {
            $application = DB::table('applications')->where('id', $id)->first();

            if (!$application) {
                return redirect()->back()->with('error', __('app.application_not_found'));
            }

            // Define base validation rules
            $validationRules = [
                "uploade_date" => "required",
                "refference_no" => "nullable|string|unique:applications,refference_no,".$id,
                "applicant" => "required",
                "identities" => "required",
                "address" => "required",
                // "postal_code" => "required|numeric|digits:6",
                "phone" => "required|numeric|digits_between:10,15",
                "email" => "required|email",
                "state" => "required",
                "city" => "required",
                "district" => "required",
                "land_lot" => "required",
                "land_area" => "required",
                "land_district" => "required",
                "land_state" => "required",
                "land_category" => "nullable",
                "hectare" => "nullable|numeric",
                "base_amount" => "nullable|numeric",
                "adjustment_percentage" => "nullable|numeric",
                "discount_amount" => "nullable|numeric",
                "final_amount" => "nullable|numeric",
                "cost" => "nullable|numeric",
                "appeal" => "nullable|in:yes,no",
                "remark" => "nullable|string|max:255",
            ];

            // Conditionally add file validation only if files are uploaded
            $fileKeys = ['land_grant', 'permission_plan'];
            foreach ($fileKeys as $key) {
                if ($request->hasFile($key)) {
                    $validationRules[$key] = 'file|mimes:pdf|max:15000';
                }
            }

            // Perform validation
            $this->validate($request, $validationRules);

            // Handle file uploads
            $uploadedFiles = [];
            $uploadPath = public_path('pdf');
        
            foreach (['land_grant', 'permission_plan', 'letter_of_support'] as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); 
                    $fileExtension = $file->getClientOriginalExtension(); 
                    $newFileName = $fileName .  '.' . $fileExtension;
            
                    // Move the file to the upload directory with the new name
                    $file->move($uploadPath, $newFileName);
            
                    // Store the new file path
                    $uploadedFiles[$fileKey] = 'pdf/' . $newFileName;
                }
            }
            
        

            // Prepare update data
            $updateData = [
                "refference_no" => $request->input('refference_no'),
                "uploade_date" => $request->input('uploade_date', $application->uploade_date),
                "applicant" => $request->input('applicant', $application->applicant),
                "identities" => $request->input('identities', $application->identities),
                "address" => $request->input('address', $application->address),
                "postal_code" => $request->input('postal_code', $application->postal_code),
                "phone" => $request->input('phone', $application->phone),
                "email" => $request->input('email', $application->email),
                "city" => $request->input('city', $application->city),
                "district" => $request->input('district', $application->district),
                "land_district" => $request->input('land_district', $application->land_district),
                 "land_state" => $request->input('land_state', $application->land_state),
                "land_lot" => $request->input('land_lot', $application->land_lot),
                "land_area" => $request->input('land_area', $application->land_area),
                "state" => $request->input('state', $application->state),
                "land_category" => $request->input('land_category'),
                "hectare" => $request->input('hectare'),
                "base_amount" => $request->input('base_amount'),
                "adjustment_percentage" => $request->input('adjustment_percentage'),
                "discount_amount" => $request->input('discount_amount'),
                "final_amount" => $request->input('final_amount'),
                "cost" => $request->input('cost'),
                "adjustment_type"=>$request->input('adjustment_type'),
                "appeal" => $request->input('appeal'), 
                "remark" => $request->input('remark'),
                "appeal_status" => $request->input('appeal') === 'yes' ? 'approved' : 'rejected'
            ];
            
            // If appeal is 'yes', change application status to pending
            if ($request->input('appeal') === 'yes') {
                $updateData['status'] = 'pending';
            }

            // Merge uploaded files only if any files were uploaded
            if (!empty($uploadedFiles)) {
                $updateData = array_merge($updateData, $uploadedFiles);
            }
            

            \Log::info("Update data:", $updateData);
            // Update the application
            DB::table('applications')->where('id', $id)->update($updateData);
            
            $oldData = (array) $application;
            $updatedApplication = DB::table('applications')->where('id', $id)->first();
            $newData = (array) $updatedApplication;
            
            
            // Track changes
            $changes = [];
            foreach ($newData as $key => $value) {
                if (array_key_exists($key, $oldData)) {  // Added missing parenthesis here
                    // Handle special cases (like dates or JSON)
                    $oldValue = is_object($oldData[$key]) ? json_encode($oldData[$key]) : $oldData[$key];
                    $newValue = is_object($value) ? json_encode($value) : $value;
                    
                    if ($oldValue != $newValue) {
                        $changes[$key] = [
                            'old' => $oldValue,
                            'new' => $newValue
                        ];
                    }
                }
            }
                
                
            // Get user info safely
            $admin = auth('admin')->user();
            $causerUsername = $admin ? $admin->username : 'System';
            $causerUuid = $admin ? $admin->uuid : null;
            
                
            // Log the activity
            ActivityLog::create([
                'log_name' => 'application',
                'description' => 'Application updated by admin: ' . $causerUsername,
                'event' => 'updated',
                'subject_type' => 'App\Models\Application',
                'subject_id' => $id,
                'properties' => $changes, // This will now contain all changed fields
                'causer_type' => $admin ? get_class($admin) : null,
                'causer_id' => $causerUuid,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            
            // If appeal is 'yes', create approver status change log
            if ($request->input('appeal') === 'yes') {
                 ApplicationLog::create([
                    'application_id' => $id,
                    'user_id' => null, // System generated
                    'user_type' => 'admin_approver',
                    'action' => 'status_reset_for_appeal',
                    'status_from' => $application->status,
                    'status_to' => 'pending',
                    'remarks' => 'Approver status reset to pending due to appeal submission',
                    'additional_data' => [
                        'performed_by' => 'System',
                        'triggered_by_admin' => $causerUsername,
                        'appeal_status' => 'approved',
                        'appeal_date' => now()->toDateTimeString(),
                        'is_appeal' => true,
                        'is_system_generated' => true,
                    ],
                ]);
                
              
            }

            return response()->json([
                'success' => true,
                'message' => __('app.application_has_been_updated')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log specific validation errors
            \Log::error('Validation Errors: ', $e->errors());
            
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Validation failed. Please check your inputs.'
            ], 422);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 500);
        }
    }


    
    public function userLetter($application_id)
    {
           $application = Application::select('applications.*', 
            'state.negeri', 
            'district.daerah', 
            'division.mukim as land_mukim',
            'land_district.daerah as land_daerah')  // Added this line
        ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
        ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
        ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
        ->leftJoin('district as land_district', 'division.daerah_id', '=', 'land_district.iddaerah')  // Added this join
        ->where('applications.id', $application_id)
        ->firstOrFail();

        return view('application.user-letter', compact('application'));
    }
    
    
    public function adminViewLetter($application_id)
    {
           $application = Application::select('applications.*', 
            'state.negeri', 
            'district.daerah', 
            'division.mukim as land_mukim',
            'land_district.daerah as land_daerah')  // Added this line
        ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
        ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
        ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
        ->leftJoin('district as land_district', 'division.daerah_id', '=', 'land_district.iddaerah')  // Added this join
        ->where('applications.id', $application_id)
        ->firstOrFail();

        return view('application.admin-view-letter', compact('application'));
    }
    
    
    
    public function sendToApprover(Request $request)
    {
        try {
            $request->validate([
                'application_id' => 'required|exists:applications,id',
            ]);
            $application = Application::findOrFail($request->application_id);
            $currentAdminStaff = auth('admin')->user();
            
            // Check authorization by role_id
            $adminStaffRoleId = '9e032984-8ef0-4e00-b7b9-439679a4d1aa';
            if ($currentAdminStaff->role_id != $adminStaffRoleId) {
                return response()->json(['success' => false, 'message' => 'Unauthorized role for this action'], 403);
            }
            
            
            $isResubmission = !is_null($application->rejected_at);
            
            $previousStatus = $application->status;
            $application->status = 'pending';
            $application->forwarded_at = now();
            $application->forwarded_by_admin_staff = true;
            
            
            // Update resubmission tracking if applicable (new code)
            if ($isResubmission) {
                $application->resubmitted_at = now();
                $application->resubmission_count = ($application->resubmission_count ?? 0) + 1;
            }
            
            $application->save();

            // Determine log status values
            $statusFrom = $previousStatus;
            $statusTo = 'pending';
            
            // Special logging for adminstaff role (checked by role_id)
            if ($currentAdminStaff->role_id == $adminStaffRoleId) {
                $statusFrom = 'pending';
                $statusTo = 'approved';
            }

            ApplicationLog::create([
                'application_id' => $application->id,
                'user_id' => $currentAdminStaff->uuid,
                'user_type' => 'admin_staff',
                'action' => $isResubmission ? 'resubmitted_to_approver' : 'forwarded_to_approver',
                'status_from' => $statusFrom,
                'status_to' => $statusTo,
                'remarks' => $isResubmission 
                ? 'Application resubmitted to approver after rejection' 
                : 'Application forwarded to approver for final review',
                'additional_data' => [
                    'performed_by' => $currentAdminStaff->username,
                    'forwarded_at' => now()->toDateTimeString(),
                    'actual_status_change' => $previousStatus . '->pending', 
                     'is_resubmission' => $isResubmission, 
                    'resubmission_count' => $isResubmission ? ($application->resubmission_count ?? 0) : 0,
                    'previous_rejection_reason' => $isResubmission ? $application->rejection_reason : null,
                ],
            ]);
            
            
            
             // **NEW: Check if there was a previous approver rejection and reset approver status**
            $lastApproverAction = ApplicationLog::where('application_id', $application->id)
                ->where('user_type', 'admin_approver')
                ->orderBy('created_at', 'desc')
                ->first();

                  if ($lastApproverAction && $lastApproverAction->status_to === 'rejected') {
                    // Create system log to reset approver status to pending
                    ApplicationLog::create([
                        'application_id' => $application->id,
                        'user_id' => null, // System generated
                        'user_type' => 'admin_approver',
                        'action' => 'reset_to_pending',
                        'status_from' => 'rejected',
                        'status_to' => 'pending',
                        'remarks' => $isResubmission
                            ? 'Approver status reset after staff resubmitted rejected application'
                            : 'Approver status reset to pending after staff re-forwarded application',
                        'additional_data' => [
                            'performed_by' => 'System',
                            'triggered_by_reforward' => $currentAdminStaff->username,
                            'is_system_generated' => true,
                            'previous_rejection_date' => $lastApproverAction->created_at->toDateTimeString(),
                            'is_resubmission' => $isResubmission, // new field
                            'resubmission_count' => $isResubmission ? ($application->resubmission_count ?? 0) : 0, 
                        ],
                    ]);
                } else {
                    // No previous rejection, create initial approver pending status
                    ApplicationLog::create([
                        'application_id' => $application->id,
                        'user_id' => null, // System generated
                        'user_type' => 'admin_approver',
                        'action' => 'awaiting_review',
                        'status_from' => null,
                        'status_to' => 'pending',
                        'remarks' => 'Application sent to approver for review',
                        'additional_data' => [
                            'performed_by' => 'System',
                            'forwarded_by' => $currentAdminStaff->username,
                            'is_system_generated' => true,
                            'is_resubmission' => false,
                        ],
                    ]);
                }


            // Find the approver
            $approverRoleId = '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d';
            $approver = User::where('role_id', $approverRoleId)->first();

            if (!$approver) {
                Log::warning('No approver found', ['role_id' => $approverRoleId]);
                return response()->json(['success' => false, 'message' => 'No approver found'], 404);
            }

            $approver->notify(new NewApplicationSent($application));
            
            ActivityLog::create([
                'log_name' => 'application',
                'description' => $isResubmission 
                    ? 'Application resubmitted to approver by admin staff' 
                    : 'Application forwarded to approver by admin staff',
                'event' => $isResubmission ? 'resubmitted' : 'forwarded',
                'subject_type' => 'App\Models\Application',
                'subject_id' => $application->id,
                'properties' => [
                    'status_change' => "$previousStatus -> pending",
                    'forwarded_by' => $currentAdminStaff->username,
                    'forwarded_at' => now()->toDateTimeString(),
                    'is_resubmission' => $isResubmission,
                    'resubmission_count' => $isResubmission ? $application->resubmission_count : 0,
                    'previous_rejection_reason' => $isResubmission ? $application->rejection_reason : null,
                    'approver_notified' => $approver ? true : false,
                ],
                'causer_type' => 'App\Models\User', // or your admin user model
                'causer_id' => $currentAdminStaff->uuid,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            
            if ($lastApproverAction && $lastApproverAction->status_to === 'rejected') {
                ActivityLog::create([
                    'log_name' => 'application',
                    'description' => 'Approver status reset to pending after staff action',
                    'event' => 'status_reset',
                    'subject_type' => 'App\Models\Application',
                    'subject_id' => $application->id,
                    'properties' => [
                        'status_change' => "rejected -> pending",
                        'triggered_by' => $currentAdminStaff->username,
                        'is_resubmission' => $isResubmission,
                        'previous_rejection_date' => $lastApproverAction->created_at->toDateTimeString(),
                    ],
                    'causer_type' => null, // System generated
                    'causer_id' => null,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Application forwarded to approver successfully',
                'forwarded_by' => $currentAdminStaff->username ?? $currentAdminStaff->email,
            ]);

        } catch (\Exception $e) {
            Log::error('Send to Approver Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Server error occurred',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }




    public function sendUserNotification(Request $request)
    {
        try {
            $request->validate([
                'application_id' => 'required|exists:applications,id',
                'notification_type' => 'required|in:approval,rejection' 
            ]);
    
            \Log::info('Send Notification Request:', [
                'application_id' => $request->application_id,
                'notification_type' => $request->notification_type
            ]);
    
            $application = Application::findOrFail($request->application_id);
    
            $client = ClientRegisterModel::where('client_id', $application->user_id)->first();
    
            if (!$client) {
                \Log::warning('No client found for application', [
                    'application_id' => $application->id,
                    'user_id' => $application->user_id
                ]);
                return response()->json(['success' => false, 'message' => 'No client associated with this application'], 404);
            }
    
            $user_client = ClientUser::where('uuid', $application->user_id)->first();
    
            if ($request->notification_type === 'approval') {
                $user_client->notify(new UserApplicationStatusNotification($application));
            } elseif ($request->notification_type === 'rejection') {
                $user_client->notify(new UserApplicationRejectionNotification($application));
            }
    
            \Log::info('Notification sent to client', [
                'application_id' => $application->id,
                'client_id' => $client->client_id,
                'notification_type' => $request->notification_type
            ]);
            return response()->json(['success' => true, 'message' => 'Notification sent to client successfully']);
        } catch (\Exception $e) {
            \Log::error('Send Notification Error: ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Server error occurred: ' . $e->getMessage()], 500);
        }
    }



    public function getCount()
    {
        $count = auth('admin')->user() 
            ? auth('admin')->user()->unreadNotifications()->count() 
            : 0;
        return response()->json(['count' => $count]);
   }

   public function markAsRead(Request $request)
   {
        $notification = auth('admin')->user()
            ->unreadNotifications
            ->where('id', $request->notification_id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    public function getNotifications()
    {
        $notifications = auth('admin')->user()
            ? auth('admin')->user()->unreadNotifications
            : collect(); // Return empty collection if no user

        return response()->json($notifications);
    }

    public function approverLetter($application_id)
    {
        $application = Application::select('applications.*', 
            'state.negeri', 
            'district.daerah', 
            'division.mukim as land_mukim',
            'land_district.daerah as land_daerah')  // Added this line
        ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
        ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
        ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
        ->leftJoin('district as land_district', 'division.daerah_id', '=', 'land_district.iddaerah')  // Added this join
        ->where('applications.id', $application_id)
        ->firstOrFail();
        $canAdminApproverApproveReject = auth('admin')->user()->hasPermission('applications_staus.change');
        return view('application.approver_letter', compact('application', 'canAdminApproverApproveReject'));
    }

    public function notification(){
        $title = __("app.notification");
        return view('notification.notification',compact('title'));
    }
        
    
    public function developer_list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $canAdminStaffViewCustomerDetails = auth('admin')->user()->hasPermission('customers.view-details');
        $canAdminStaffEditCustomerDetails = auth('admin')->user()->hasPermission('customers.edit');
        $isAuthenticated = auth('admin')->check();
        $isAdminOrStaff = false;
            
        if ($isAuthenticated) {
            $roleId = auth('admin')->user()->role_id;
            $isAdminOrStaff = ($roleId === '5c7f11d2-7091-4d10-aaeb-a9b4e3b76a76');
        }

        $query = DB::table('client_register')
            ->join('account_types', 'client_register.accountType', '=', 'account_types.id')
            ->leftJoin(DB::raw('(SELECT user_id, MAX(created_at) as latest_application
                            FROM applications
                            GROUP BY user_id) as latest_app'), 
                function($join) {
                    $join->on('client_register.client_id', '=', 'latest_app.user_id');
                })
            ->leftJoin('applications', function($join) {
                $join->on('latest_app.user_id', '=', 'applications.user_id')
                    ->on('latest_app.latest_application', '=', 'applications.created_at');
            })
            ->leftJoin(DB::raw('(SELECT client_id, MAX(is_admin_locked) as is_blocked 
                            FROM password_attempts 
                            GROUP BY client_id) as pa'), 
                    'client_register.client_id', '=', 'pa.client_id')
            ->select(
                'client_register.*',
                'account_types.name as account_type_name',
                'applications.land_district',
                'applications.land_state',
                'pa.is_blocked'
            );
            
        if ($request->has('district') && $request->district) {
            $query->where('applications.land_district', $request->district);
        }
            
        if ($request->has('division') && $request->division) {
            $query->where('applications.land_state', $request->division);
        }
            
        if ($request->has('name') && $request->name) {
            $query->where('client_register.name', 'LIKE', '%' . $request->name . '%');
        }
            
        if ($request->has('reg_no') && $request->reg_no) {
            $query->where('client_register.registration_no', 'LIKE', '%' . $request->reg_no . '%');
        }
            
        if ($request->has('account_type') && $request->account_type) {
            $query->where('client_register.accountType', $request->account_type);
        }
            
        $client_register = $query->orderBy('client_register.created_at', 'desc')
            ->distinct() 
            ->paginate($perPage)
            ->appends($request->except('page'));
            
        $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
        $account_types = DB::table('account_types')->get();
            
        return view('application.developer_list', compact(
            'client_register',
            'district',
            'account_types',
            'perPage',
            'isAdminOrStaff',
            'canAdminStaffViewCustomerDetails',
            'canAdminStaffEditCustomerDetails'
        ));
    }
    
    
    // public function applicationStatus(Request $request) 
    // {         
    //     $perPage = $request->input('per_page', 10);         
    //     $statusFilter = $request->input('status');                  
        
    //     $query = Application::with([
    //         'client',
    //         'logs' => function($query) {
    //             $query->orderBy('action_at', 'desc');
    //         }
    //     ])->orderBy('created_at', 'desc');                  
        
    //     if ($statusFilter) {             
    //         $query->where('status', $statusFilter);         
    //     }                  
        
    //     // Total counts (unfiltered)         
    //     $allCount = Application::count();         
    //     $approvedCount = Application::where('status', 'approved')->count();         
    //     $rejectedCount = Application::where('status', 'rejected')->count();                  
        
    //     $isAuthenticated = auth('admin')->check();         
    //     $isAdminOrStaff = false;                   
        
    //     if ($isAuthenticated) {             
    //         $roleId = auth('admin')->user()->role_id;             
    //         $isAdminOrStaff = ($roleId === '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d');         
    //     }                  
        
    //     $applications = $query->paginate($perPage);                  
        
    //     return view('application.application-status', compact(             
    //         'applications',              
    //         'allCount',              
    //         'approvedCount',              
    //         'rejectedCount',              
    //         'perPage',             
    //         'statusFilter',             
    //         'isAdminOrStaff'         
    //     ));     
    // }
    
    
    public function applicationStatus(Request $request) 
    {         
        $perPage = $request->input('per_page', 10);         
        $statusFilter = $request->input('status');
        $adminStaffStatus = $request->input('admin_staff_status');
        $approverStatus = $request->input('approver_status');
        $searchTerm = $request->input('search');
        
        $isStaffAdmin = false;         
        if (auth('admin')->check()) {             
            $roleId = auth('admin')->user()->role_id;             
            $isStaffAdmin = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');         
        }
        
        $isApproverAdmin = false;         
        if (auth('admin')->check()) {             
            $roleId = auth('admin')->user()->role_id;             
            $isApproverAdmin = ($roleId === '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d');         
        }
        
        $query = Application::with([
            'client',
            'logs' => function($query) {
                $query->orderBy('action_at', 'desc');
            }
        ])->orderBy('created_at', 'desc');    
        
        
         if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('refference_no', 'like', "%{$searchTerm}%")
                  ->orWhere('applicant', 'like', "%{$searchTerm}%")
                  ->orWhere('land_lot', 'like', "%{$searchTerm}%")
                  ->orWhereHas('client', function($q) use ($searchTerm) {
                      $q->where('userName', 'like', "%{$searchTerm}%");
                  });
            });
        }
        
        // Apply status filter if exists
        if ($statusFilter) {             
            $query->where('status', $statusFilter);         
        }
        
        // Apply Admin Staff status filter - filter by LATEST log only
        if ($adminStaffStatus && $adminStaffStatus != 'all') {
            $query->whereHas('logs', function($q) use ($adminStaffStatus) {
                $q->where('user_type', 'admin_staff')
                ->where('status_to', $adminStaffStatus)
                ->whereRaw('action_at = (
                    SELECT MAX(action_at) 
                    FROM application_logs l2 
                    WHERE l2.application_id = application_logs.application_id 
                    AND l2.user_type = "admin_staff"
                )');
            });
        }
        
        // Apply Approver status filter - filter by LATEST log only
        if ($approverStatus && $approverStatus != 'all') {
            $query->whereHas('logs', function($q) use ($approverStatus) {
                $q->where('user_type', 'admin_approver')
                ->where('status_to', $approverStatus)
                ->whereRaw('action_at = (
                    SELECT MAX(action_at) 
                    FROM application_logs l2 
                    WHERE l2.application_id = application_logs.application_id 
                    AND l2.user_type = "admin_approver"
                )');
            });
        }
        
         $countQuery = Application::query();
        
        if ($searchTerm) {
            $countQuery->where(function($q) use ($searchTerm) {
                $q->where('refference_no', 'like', "%{$searchTerm}%")
                  ->orWhere('applicant', 'like', "%{$searchTerm}%")
                  ->orWhere('land_lot', 'like', "%{$searchTerm}%")
                  ->orWhereHas('client', function($q) use ($searchTerm) {
                      $q->where('userName', 'like', "%{$searchTerm}%");
                  });
            });
        }
        
        // Get counts for all filters
        // $allCount = Application::count();
        $allCount = $countQuery->count();
        $approvedCount = Application::where('status', 'approved')->count();
        $rejectedCount = Application::where('status', 'rejected')->count();
    
    
        
        $isAuthenticated = auth('admin')->check();         
        $isAdminOrStaff = false;                   
        
        if ($isAuthenticated) {             
            $roleId = auth('admin')->user()->role_id;             
            $isAdminOrStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');         
        }                  
        
        $applications = $query->paginate($perPage);                  
        
        return view('application.application-status', compact(             
            'applications',              
            'allCount',              
            'approvedCount',              
            'rejectedCount',
            'perPage',             
            'statusFilter',
            'adminStaffStatus',
            'approverStatus',
            'isAdminOrStaff' ,
            'isStaffAdmin',
            'isApproverAdmin',
            'searchTerm'
        ));     
    }

    
    
    public function paymentUpdate(Request $request, $application_id)
    {
        $application = Application::findOrFail($application_id);
        
        $validated = $request->validate([
            'payment_method' => 'required|in:online,cheque,bank_transfer',
            'payment_status' => 'required|in:completed,pending,failed,in_review',
            'receipt_number' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string',
            'cheque_number' => 'required_if:payment_method,cheque|string|max:255',
            'cheque_date' => 'required_if:payment_method,cheque|date',
            'bank_name' => 'required_if:payment_method,cheque|string|max:255',
            'deposit_date' => 'nullable|date',
            'transaction_id' => 'required_if:payment_method,bank_transfer|string|max:255',
            'transfer_date' => 'required_if:payment_method,bank_transfer|date',
            'from_bank' => 'required_if:payment_method,bank_transfer|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'receipt_upload' => 'required_if:payment_method,bank_transfer|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'gateway_transaction_id' => 'nullable|string|max:255',
            'payment_gateway' => 'nullable|in:fpx,credit_card,paypal,stripe,razorpay',
            'gateway_response' => 'nullable|string',
        ]);

        $receiptNumber = null;
        
        if ($request->has('receipt_number') && !empty(trim($request->receipt_number))) {
            $receiptNumber = trim($request->receipt_number);
            \Log::info('Using manually entered receipt number: ' . $receiptNumber);
        } else {
            $currentDate = Carbon::now();
            $year = $currentDate->format('y');
            $month = $currentDate->format('m');
            $day = $currentDate->format('d');

            // UPDATED: Find the maximum sequential number from payments table globally
            $maxSequence = \DB::select("
                SELECT MAX(CAST(RIGHT(receipt_number, 6) AS UNSIGNED)) as max_seq 
                FROM payments 
                WHERE receipt_number LIKE ? 
                AND receipt_number IS NOT NULL
            ", [$year . 'JPSSEL%']);

             $nextSequence = 1;
                if (!empty($maxSequence) && $maxSequence[0]->max_seq) {
                    $nextSequence = $maxSequence[0]->max_seq + 1;
                }
        
                $sequentialNumber = str_pad($nextSequence, 6, '0', STR_PAD_LEFT);
                $receiptNumber = $year . 'JPSSEL' . $month . $day . $sequentialNumber;
        }

        // Handle file upload for bank transfer
        $bankTransferReceiptPath = null;
        if ($request->hasFile('receipt_upload') && $request->payment_method === 'bank_transfer') {
            $bankTransferReceiptPath = $request->file('receipt_upload')->store('bank_receipts', 'public');
        }

        // Generate transaction ID based on payment method
        $transactionId = null;
        switch ($validated['payment_method']) {
            case 'online':
                $transactionId = $request->gateway_transaction_id
                    ?? $request->transaction_id
                    ?? 'ONL-'.mt_rand(1000000000,9999999999);
                break;
        
            case 'bank_transfer':
                $transactionId = $request->transaction_id
                    ? 'BT-'.$request->transaction_id
                    : 'BT-'.mt_rand(1000000000,9999999999);
                break;
        
            case 'cheque':
                // Always prefix CHQ- to the provided cheque number
                if ($request->cheque_number) {
                    $transactionId = 'CHQ-'.$request->cheque_number;
                } else {
                    $transactionId = 'CHQ-'.mt_rand(1000000000,9999999999);
                }
                break;
        
            default:
                $transactionId = $request->gateway_transaction_id
                    ?? $request->transaction_id
                    ?? 'TXN-'.mt_rand(1000000000,9999999999);
       }

        $paymentDate = null;
        switch ($validated['payment_method']) {
            case 'online':
                $paymentDate = Carbon::now();
                break;
                
            case 'bank_transfer':
                $paymentDate = $request->transfer_date ? Carbon::parse($request->transfer_date) : Carbon::now();
                break;
                
            case 'cheque':
                $paymentDate = $request->deposit_date ? 
                    Carbon::parse($request->deposit_date) : 
                    ($request->cheque_date ? Carbon::parse($request->cheque_date) : Carbon::now());
                break;
                
            default:
                $paymentDate = Carbon::now();
        }

        // Prepare update data for Application table
        $applicationUpdateData = [
            'payment_status' => $validated['payment_status'],
            'transaction' => $transactionId, 
            'reciept_number' => $receiptNumber, // This should save the receipt number
            'deposit_date' => $paymentDate,
            'payment_rejection_reason' => $validated['payment_status'] === 'failed' ? 
                ($request->admin_notes ?? 'Payment failed') : null,
            'receipt_path' => $bankTransferReceiptPath ?? $application->receipt_path,
        ];

        \Log::info('Updating Application with data: ', $applicationUpdateData);

        // Update Application table
        $updateResult = $application->update($applicationUpdateData);
        
        \Log::info('Application update result: ' . ($updateResult ? 'SUCCESS' : 'FAILED'));
        
        // Verify the update by refreshing and checking
        $application->refresh();
        \Log::info('Application receipt_number after update: ' . $application->receipt_number);


        $payment = Payment::updateOrCreate(
            ['application_id' => $application->id],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'application_id' => $application->id,
                'payment_date' => $paymentDate,
                'amount' => $application->final_amount,
                'method' => $validated['payment_method'],
                'payment_status' => $validated['payment_status'],
                'transaction_id' => $transactionId,
                'receipt_number' => $receiptNumber,
                'payment_rejection_reason' => $validated['payment_status'] === 'failed' ? 
                    ($request->admin_notes ?? 'Payment failed') : null,
                'receipt_path' => $bankTransferReceiptPath ?? null,
                
                // Cheque specific fields
                'cheque_number' => $request->cheque_number ?? null,
                'cheque_date' => $request->cheque_date ?? null,
                'cheque_bank_name' => $request->bank_name ?? null,
                
                // Bank transfer specific fields
                'bank_transfer_transaction_id' => $request->transaction_id ?? null,
                'transfer_date' => $request->transfer_date ?? null,
                'from_bank' => $request->from_bank ?? null,
                'account_number' => $request->account_number ?? null,
                'bank_transfer_receipt_path' => $bankTransferReceiptPath ?? null,
                
                // Online payment specific fields
                'gateway_transaction_id' => $transactionId,
                'payment_gateway' => $request->payment_gateway ?? null,
                'gateway_response' => $request->gateway_response ?? null,
                
                // Common fields
                'admin_notes' => $request->admin_notes ?? null,
            ]
        );

        \Log::info('Payment record updated/created with receipt_number: ' . $payment->receipt_number);

        return response()->json([
            'success' => true,
            'message' => trans('app.payment_updated_successfully'),
            'data' => [
                'transaction_id' => $transactionId,
                'receipt_number' => $receiptNumber,
                'payment_date' => $paymentDate->format('Y-m-d H:i:s'),
                'application_receipt_number' => $application->receipt_number, 
            ]
        ]);
    }
    

    
    
    public function viewReceipt(Request $request)     
    {         
            $perPage = $request->input('per_page', 10);
            $statusFilter = $request->input('status_filter', 'all'); 
            $search = $request->input('q');
            
            $query = Application::with(['state', 'landDistrict', 'landDivision', 'client', 'latestPayment'])
                ->where('status', 'approved')
                ->orderBy('created_at', 'desc');         
            
            $canApproverViewReciept = auth('admin')->user()->hasPermission('payments.view-details');          
        
            $isFinanceAdmin = false;         
            if (auth('admin')->check()) {             
                $roleId = auth('admin')->user()->role_id;             
                $isFinanceAdmin = ($roleId === '9e032970-5f48-4d2b-b88e-abb9da79140f');         
            }          
        
               // Filter based on payments table payment_status
            switch ($statusFilter) {
                        case 'completed':
                            $query->whereHas('payment', function($q) {
                                $q->where('payment_status', 'completed');
                            });
                            break;
                            
                        case 'failed':
                            $query->whereHas('payment', function($q) {
                                $q->where('payment_status', 'failed');
                            });
                            break;
                            
                        case 'pending':
                        case 'pending_authorization':
                            $query->whereHas('payment', function($q) {
                                $q->where('payment_status', 'pending_authorization');
                            });
                            break;
                            
                        case 'incomplete':
                        case 'no_payment':
                            // Applications without any payment record (approved but no payment)
                            $query->whereDoesntHave('payment');
                            break;
                            
                        case 'in_review':
                            $query->whereHas('payment', function($q) {
                                $q->where('payment_status', 'in_review');
                            });
                            break;
                            
                        case 'all':
                        default:
                            // No additional filtering - show all approved applications regardless of payment status
                            break;
                    }
            
            $query->when($search, function ($q) use ($search) {
                $like = "%{$search}%";
                $q->where(function ($sub) use ($like) {
                    $sub->where('refference_no', 'like', $like)
                        ->orWhere('applicant', 'like', $like)
                        ->orWhere('land_lot', 'like', $like)
                        ->orWhere('final_amount', 'like', $like)
                        ->orWhereHas('client', function($clientQuery) use ($like) {
                            $clientQuery->where('userName', 'like', $like);
                        });
                });
            });


        $list = $query->paginate($perPage)->withQueryString();

        return view('application.view-receipt', compact(
            'list', 
            'canApproverViewReciept', 
            'perPage', 
            'isFinanceAdmin',
            'statusFilter' 
        ));     
    }
    
    public function userReceipt(){
        $list = Application::with(['state', 'landDistrict', 'landDivision', 'client'])
            ->latest()
            ->paginate($perPage);
        return view('application.user-receiptoriginal', compact('list'));
    }
    
    
    //  public function userReceiptView($application_id)
    //     {
    //         $application = Application::select('applications.*', 'state.negeri', 'district.daerah')
    //             ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
    //             ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
    //             ->where('applications.id', $application_id)
    //             ->firstOrFail();
        
    //         return view('application.user-receiptoriginal', compact('application'));
    //     }
    
    
    public function userReceiptView($application_id)
    {
        $application = Application::with(['payment']) 
            ->select(
                'applications.*', 
                'state.negeri', 
                'district.daerah',
                'payments.payment_status as payment_status', 
                'payments.method as payment_method',
                'payments.amount as payment_amount',
                'payments.transaction_id',
                'payments.receipt_number as receipt_number',
                'payments.created_at as payment_date'
            )
            ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
            ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
            ->leftJoin('payments', 'applications.id', '=', 'payments.application_id')
            ->where('applications.id', $application_id)
            ->firstOrFail();

    
        return view('application.user-receiptoriginal', compact('application'));
    }
    
    public function adminuserReceiptCopy(){
        return view('application.user-receiptcopy');
    }
        public function payment_report(){
        return view('application.payment_report');
    }
    
      public function contribution_payment_report(){
           $title = __("Contribution Payment Report");
        $districts = DB::table('district')->get();
        return view('application.contribution-payment-report',['title' => $title,
         'districts'=> $districts]);
    }


    public function contributionPaymentReportDetail(Request $request)
    {
        $request->validate([
            'district_id' => 'nullable|integer',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'print_type' => 'nullable|string',
        ]);
        
        $districtId = $request->input('district_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $printType = $request->input('print_type');
        
        // Get district name when a specific district is selected
        $selectedDistrictName = null;
        if ($districtId && $districtId != '') {
            $district = DB::table('district')->where('iddaerah', $districtId)->first();
            if ($district) {
                $selectedDistrictName = $district->daerah;
            }
        }
        
        $query = DB::table('applications')
            ->join('client_register', 'applications.user_id', '=', 'client_register.client_id')
            ->join('district', 'applications.district', '=', 'district.iddaerah')
            ->join('account_types', 'client_register.accountType', '=', 'account_types.id')
            ->select(
                'applications.*',
                'client_register.userName as client_name',
                'district.daerah as district_name',
                'account_types.name as account_type_name'
            );
        
        if ($districtId && $districtId != '') {
            $query->where('applications.district', $districtId);
        }
        
        if ($startDate && $endDate) {
            try {
                $startDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTimeString();
                $endDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTimeString();
                $query->whereBetween('applications.created_at', [$startDateParsed, $endDateParsed]);
            } catch (\Exception $e) {
                \Log::error('Invalid date format: ' . $e->getMessage());
                return back()->withErrors(['date' => 'Invalid date format. Use YYYY-MM-DD.']);
            }
        }
        
        $applications = $query->get();
        
        \Log::info('Applications Count: ' . $applications->count());
        \Log::info('Applications created_at: ' . json_encode($applications->pluck('created_at')->toArray()));
        
        if ($startDate && $endDate) {
            $outOfRange = $applications->filter(function ($app) use ($startDateParsed, $endDateParsed) {
                return \Carbon\Carbon::parse($app->created_at)->lt($startDateParsed) || \Carbon\Carbon::parse($app->created_at)->gt($endDateParsed);
            });
            if ($outOfRange->isNotEmpty()) {
                \Log::warning('Out-of-range records: ' . json_encode($outOfRange->toArray()));
            }
        }
        
        $currentDateTime = \Carbon\Carbon::now();
        $currentDate = $currentDateTime->format('d/m/Y');
        $currentTime = $currentDateTime->format('h:i:s A');
        
        // Format dates for display
        $formattedStartDate = \Carbon\Carbon::parse($startDate)->format('d/m/Y');
        $formattedEndDate = \Carbon\Carbon::parse($endDate)->format('d/m/Y');
        
        return view('application.contribution-payment-report-detail', [
            'title' => __("Contribution Payment Report "),
            'applications' => $applications,
            'printType' => $printType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'formattedStartDate' => $formattedStartDate,
            'formattedEndDate' => $formattedEndDate,
            'currentDate' => $currentDate,
            'currentTime' => $currentTime,
            'selectedDistrictName' => $selectedDistrictName,
            'isFilteredByDistrict' => ($districtId && $districtId != '')
        ]);
    }
    
    public function paymentReceipt(Request $request){
        $request->validate([
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
            'print_type' => 'nullable|string',
        ]);
        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $printType = $request->input('print_type');
        $perPage = $request->input('per_page', 10);
        
        $query = DB::table('applications')
            ->join('client_register', 'applications.user_id', '=', 'client_register.client_id')
            ->join('district', 'applications.district', '=', 'district.iddaerah')
            ->join('state', 'applications.state', '=', 'state.idnegeri')
            ->join('account_types', 'client_register.accountType', '=', 'account_types.id')
            ->leftJoin('payments', 'applications.id', '=', 'payments.application_id') 
            ->select(
                'applications.*',
                'client_register.userName as client_name',
                'district.daerah as district_name',
                'state.negeri as state_name',
                'account_types.name as account_type_name',
                'payments.uuid as payment_id',
                'payments.amount as payment_amount',
                'payments.payment_date',
                'payments.method',
                'payments.transaction_id',
                'payments.payment_status',
                'payments.receipt_number',
                'payments.created_at as payment_created_at'
            )
            ->where('payments.payment_status', 'completed')
            ->orderBy('applications.created_at', 'desc');
        
        if ($startDate && $endDate) {
            try {
                $startDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTimeString();
                $endDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTimeString();
                $query->whereBetween('applications.created_at', [$startDateParsed, $endDateParsed]);
            } catch (\Exception $e) {
                \Log::error('Invalid date format: ' . $e->getMessage());
                return back()->withErrors(['date' => 'Invalid date format. Use YYYY-MM-DD.']);
            }
        }
        

        $allApplications = $query->get();
        \Log::info('Applications Count: ' . $allApplications->count());
        \Log::info('Applications created_at: ' . json_encode($allApplications->pluck('created_at')->toArray()));
        
        if ($startDate && $endDate) {
            $outOfRange = $allApplications->filter(function ($app) use ($startDateParsed, $endDateParsed) {
                return \Carbon\Carbon::parse($app->created_at)->lt($startDateParsed) || \Carbon\Carbon::parse($app->created_at)->gt($endDateParsed);
            });
            if ($outOfRange->isNotEmpty()) {
                \Log::warning('Out-of-range records: ' . json_encode($outOfRange->toArray()));
            }
        }
        
        $applications = $query->paginate($perPage)->withQueryString();
        
        $currentDateTime = \Carbon\Carbon::now();
        $currentDate = $currentDateTime->format('d/m/Y');
        $currentTime = $currentDateTime->format('h:i:s A');
        
        return view('application.list-of-receipt', [
            'applications' => $applications,
            'printType' => $printType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentDate' => $currentDate,
            'currentTime' => $currentTime
        ]);
    }
    
    public function collectors_receipt(Request $request) {
        try {
            \Log::info('Collectors receipt request received', ['request' => $request->all()]);
            
            $validator = Validator::make($request->all(), [
                'selectedReceipts' => 'required',
                'startDate' => 'nullable|date_format:Y-m-d',
                'endDate' => 'nullable|date_format:Y-m-d',
            ]);
            
            if ($validator->fails()) {
                \Log::error('Validation failed', ['errors' => $validator->errors()]);
                return response()->json(['error' => $validator->errors()], 422);
            }
            
            $selectedReceipts = json_decode($request->selectedReceipts, true);
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            
            \Log::info('Date range', ['startDate' => $startDate, 'endDate' => $endDate]);
            
            if ($selectedReceipts === null && json_last_error() !== JSON_ERROR_NONE) {
                $errorMsg = 'JSON decode error: ' . json_last_error_msg();
                \Log::error($errorMsg);
                return response()->json(['error' => $errorMsg], 400);
            }
            
            \Log::info('Selected receipts decoded successfully', ['count' => count($selectedReceipts)]);
            
            if (!view()->exists('application.collectors-receipt')) {
                \Log::error('View does not exist: application.collectors-receipt');
                return response()->json(['error' => 'View not found'], 404);
            }
            
            $totalAmount = array_reduce($selectedReceipts, function ($carry, $receipt) {
                \Log::info('Processing amount', ['raw_amount' => $receipt['amount']]);
                $cleanAmount = str_replace(['RM', ' ', ','], '', $receipt['amount']);
                $amount = floatval($cleanAmount);
                \Log::info('Cleaned amount', ['clean_amount' => $cleanAmount, 'float_amount' => $amount]);
                
                return $carry + $amount;
            }, 0);
            
            $currentDateTime = \Carbon\Carbon::now();
            $currentDate = $currentDateTime->format('d/m/Y');
            $currentTime = $currentDateTime->format('h:i:s A');
            $formattedStartDate = $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : null;
            $formattedEndDate = $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : null;
            
            return view('application.collectors-receipt', [
                'selectedReceipts' => $selectedReceipts,
                'currentDate' => $currentDate,
                'currentTime' => $currentTime,
                'totalAmount' => number_format($totalAmount, 2, '.', ','),
                'startDate' => $startDate,
                'endDate' => $endDate,
                'formattedStartDate' => $formattedStartDate,
                'formattedEndDate' => $formattedEndDate
            ]);
        } catch (\Exception $e) {
            \Log::error('Collectors receipt error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    
    // reviewer start
    
    public function reviewLetter($application_id){
        // $application = Application::findOrFail($application_id);
         $application = Application::select('applications.*', 
            'state.negeri', 
            'district.daerah', 
            'division.mukim as land_mukim',
            'land_district.daerah as land_daerah')
            ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
            ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
            ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
            ->leftJoin('district as land_district', 'division.daerah_id', '=', 'land_district.iddaerah') 
            ->where('applications.id', $application_id)
            ->firstOrFail();
            return view('reviewer.reviewuser-letter', compact('application'));
    }
    
    public function approver_receiptoriginal(){
        return view('reviewer.approver_receiptoriginal');
    }
    
    public function searchFilter(Request $request)
    {
        $title = __("app.search");
        
        $divisions = DB::table('division')
            ->where('status', 1)
            ->orderBy('mukim_code', 'asc')
            ->get();
            
        $districts = DB::table('district')
            ->where('stat', 1)
            ->orderBy('daerah_code', 'asc')
            ->get();
            
        $applicants = ClientRegisterModel::select('client_id', 'userName')->get();
        
        $lotPts = Application::select('id', 'land_lot as lot_number')
            ->whereNotNull('land_lot')
            ->distinct('land_lot')
            ->orderBy('land_lot', 'asc')
            ->get();
            
        $results = [];
        
        if ($request->isMethod('post')) {
            $query = Application::query();
    
            if ($request->filled('lot_pt_grant')) {
                $query->where('land_lot', 'like', '%' . $request->lot_pt_grant . '%');
            }
            
            if ($request->filled('division')) {
                $query->where('land_state', $request->division);
            }
            
            
            if ($request->filled('district')) {
                $query->where('land_district', $request->district);
            }
            
            if ($request->filled('applicant_id')) {
                $query->where('user_id', $request->applicant_id);
            }
            
            if ($request->filled('reference_number')) {
                $query->where('refference_no', 'like', '%' . $request->reference_number . '%');
            }
            
            if ($request->filled('application_date')) {
                $query->whereDate('created_at', $request->application_date);
            }
            
            // Eager load both relationships
            $results = $query->with(['applicant', 'division', 'district'])->get();
            
        }
        
        return view('search-filter', [
            'title' => $title,
            'divisions' => $divisions,
            'districts' => $districts,
            'applicants' => $applicants,
            'lotPts' => $lotPts,
            'results' => $results,
            'request' => $request
        ]);
    }
   public function userDetails($id)
   {
       $title = __("app.user_details");
       $states = DB::table('state')->where('status', 1)->orderBy('negeri_code', 'asc')->get();
       $districts = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
       $accountTypes = DB::table('account_types')->get();
   
       // Fetch user details using client_id
       $ClientRegister = DB::table('client_register')
        ->leftJoin('account_types', 'client_register.accountType', '=', 'account_types.id') // Left join to include all clients
        ->select('client_register.*', 'account_types.name as account_type_name') // Select account type name
        ->where('client_register.id', $id)
        ->first();
        // dd($ClientRegister);
       if (!$ClientRegister) {
           return redirect()->back()->with('error', 'User not found.');
       }
       
            // Fetch security questions
            $securityQuestion1 = DB::table('security_questions')
            ->where('question_key', $ClientRegister->securityQuestion1)
            ->value('question');

        $securityQuestion2 = DB::table('security_questions')
            ->where('question_key', $ClientRegister->securityQuestions2)
            ->value('question');

        // Debug: Check if Laravel fetched the question correctly
        \Log::info('Fetched securityQuestion1:', ['text' => $securityQuestion1]);
        \Log::info('Fetched securityQuestion2:', ['text' => $securityQuestion2]);
       return view('admin.user-details', compact('title', 'ClientRegister', 'states', 'districts', 'accountTypes', 'securityQuestion1', 'securityQuestion2'));
   }
   

   public function userDetailsUpdate($id)
{
    $title = __("app.user_details");
    $states = DB::table('state')->where('status', 1)->orderBy('negeri_code', 'asc')->get();
    $districts = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
    
    // Fetch user details by ID
    // Fetch user details with account type name
    $ClientRegister = DB::table('client_register')
        ->leftJoin('account_types', 'client_register.accountType', '=', 'account_types.id') // Join account_types
        ->select('client_register.*', 'account_types.name as account_type_name') // Select account type name
        ->where('client_register.id', $id)
        ->first();

    if (!$ClientRegister) {
        return redirect()->back()->with('error', 'User not found.');
    }
    // Debug: Check stored securityQuestion keys
    \Log::info('Stored securityQuestion1:', ['key' => $ClientRegister->securityQuestion1]);
    \Log::info('Stored securityQuestion2:', ['key' => $ClientRegister->securityQuestions2]);

    // Fetch security questions
    $securityQuestion1 = DB::table('security_questions')
        ->where('question_key', $ClientRegister->securityQuestion1)
        ->value('question');

    $securityQuestion2 = DB::table('security_questions')
        ->where('question_key', $ClientRegister->securityQuestions2)
        ->value('question');

    // Debug: Check if Laravel fetched the question correctly
    \Log::info('Fetched securityQuestion1:', ['text' => $securityQuestion1]);
    \Log::info('Fetched securityQuestion2:', ['text' => $securityQuestion2]);
    // Pass the variables to the view
    return view('admin.user-details-update', compact('title', 'ClientRegister', 'states', 'districts', 'securityQuestion1', 'securityQuestion2'));
}

public function updateUserDetails(Request $request, $id)
{
    try {
        \Log::info("Update request data:", $request->all()); // Log the request data

        // Validate the request
        $this->validate($request, [
            'userName'          => 'required|string|max:255',
            'idCardNumber'      => 'required|string|max:50',
            'registeredAddress' => 'required|string|max:255',
            'postalCode'        => 'required|string|max:10',
            'state'             => 'required',  
            'district'          => 'required',  
            'city'              => 'required|string|max:255',
            'mobileNumber'      => 'required|string|max:15',
            'landline'          => 'required|string|max:15',
        ]);

        // Fetch state and district data
        $stateData  = DB::table('state')->where('idnegeri', $request->state)->first();
        $districtData = DB::table('district')->where('iddaerah', $request->district)->first();

        if (!$stateData || !$districtData) {
            \Log::error("Invalid state or district selected.");
            return redirect()->back()->with('error', 'Invalid state or district.');
        }

        // Update user details
        $updated = DB::table('client_register')->where('id', $id)->update([
            'userName'          => $request->userName,
            'idCardNumber'      => $request->idCardNumber,
            'registeredAddress' => $request->registeredAddress,
            'postalCode'        => $request->postalCode,
            'state_id'          => $stateData->idnegeri,
            'state'             => $stateData->negeri,
            'district_id'       => $districtData->iddaerah,
            'district'          => $districtData->daerah,
            'city'              => $request->city,
            'mobileNumber'      => $request->mobileNumber,
            'landline'          => $request->landline,
        ]);

        if ($updated) {
            \Log::info("User details updated successfully for ID: $id");
        } else {
            \Log::warning("Update failed for user ID: $id");
        }

        return redirect()->back()->with('success', 'User details updated successfully!');
    } catch (\Exception $e) {
        \Log::error("Update Error: " . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}

    public function userApplicationStatus()
    {
        return view('userApplicationStatus');
    }
    public function userRegistration()
    {
        return view('userRegistration');
    }

    public function markAllAsRead()
    {
        try {
            $user = auth::guard('admin')->user();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $user->unreadNotifications()->update(['read_at' => now()]);

            return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    public function markAsReads($id)
    {
        try {
            $user = auth::guard('admin')->user();

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }
            $notification = $user->notifications()->where('id', $id)->first();

            if (!$notification) {
                return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
            }

            $notification->markAsRead();

            return response()->json(['success' => true, 'message' => 'Notification marked as read']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    
    
    // public function changePassword($uuid)
    // {
    //     // Check if user is authenticated
    //     if (!auth('admin')->check()) {
    //         return redirect()->route('admin.login')->with('error', 'Please login to access this page');
    //     }
        
    //     $loggedInUser = auth('admin')->user();
    //     if ($loggedInUser->uuid !== $uuid) {
    //         return redirect()->back()->with('error', 'You can only change your own password');
    //     }
    
    //     $title = trans('app.change_password');
        
    //     return view('auth.change_password', [
    //         'title' => $title,
    //         'uuid'=> $uuid
    //     ]);
    // }
    
    public function changePassword($uuid)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access this page');
        }
        
        $loggedInUser = auth('admin')->user();
        if ($loggedInUser->uuid !== $uuid) {
            return redirect()->back()->with('error', 'You can only change your own password');
        }
    
        $title = trans('app.change_password');
        $lockedUntil = $this->getAdminLockoutTime($uuid);
        $isLocked = false;
        $remainingTime = null;

        if ($lockedUntil && $lockedUntil > Carbon::now()) {
            $isLocked = true;
            $remainingTime = Carbon::now()->diffInMinutes($lockedUntil) + 1; 
        }
        
        return view('auth.change_password', [
            'title' => $title,
            'uuid'=> $uuid,
            'isLocked'=> $isLocked,
            'remainingTime'=> $remainingTime
        ]);
    }



    // public function updatePassword(Request $request, $uuid)
    // {
    //     $isAuthenticated = auth('admin')->check();
        
    //     if (!$isAuthenticated) {
    //         return redirect()->route('admin.login')->with('error', 'Please login to access this page');
    //     }
        
    //     $request->validate([
    //         'old_password' => 'required',
    //         'new_password' => 'required|min:8|max:20|confirmed',
    //     ]);
    
    //     $user = User::where('uuid', $uuid)->first();
        
    //     if (!$user) {
    //         return redirect()->back()->with('error', 'User not found');
    //     }
    
    //     if (!Hash::check($request->old_password, $user->password)) {
    //         return redirect()->back()->with('error', 'Old password is incorrect');
    //     }
        
    //     $user->password = Hash::make($request->new_password);
    //     $user->save();
        
    //     return redirect()->back()->with('success', 'Password updated successfully');
    // }
    
    
    public function updatePassword(Request $request, $uuid)
    {
        $isAuthenticated = auth('admin')->check();
            
        if (!$isAuthenticated) {
            return redirect()->route('admin.login')->with('error', 'Please login to access this page');
        }

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
        
        $lockedUntil = $this->getAdminLockoutTime($uuid);
       if ($lockedUntil && $lockedUntil > Carbon::now()) {
            $remainingTime = Carbon::now()->diffInMinutes($lockedUntil) + 1;
            return response()->json([
                'success' => false,
                'errors' => [
                    'old_password' => [__('app.account_locked', ['minutes' => $remainingTime])]
                ]
            ], 422);
        }
        
        $user = User::where('uuid', $uuid)->first();
            
        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => ['general' => [__('app.user_not_found')]]
            ], 404);
        }
        
        if (!Hash::check($request->old_password, $user->password)) {
            $this->recordAdminFailedAttempt($uuid);
            $attempts = $this->getAdminFailedAttempts($uuid);
            $remainingAttempts = 5 - $attempts;
            
             if ($attempts >= 5) {
                $this->lockAdminAccount($uuid);
                
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
        
        // Reset failed attempts since password was correct
       $this->resetFailedAttempts($uuid);
        
        $user->password = Hash::make($request->new_password);
        $user->save();
            
        return response()->json([
            'success' => true,
            'message' => __('app.password_updated_successfully')
        ]);
    }
    
    
    private function recordAdminFailedAttempt($uuid)
    {
        PasswordAttempt::create([
            'admin_id' => $uuid,
            'attempt_time' => Carbon::now(),
            'successful' => false
        ]);
    }
    
    
    private function getAdminFailedAttempts($uuid)
    {
        return PasswordAttempt::where('admin_id', $uuid)
            ->where('successful', false)
            ->where('attempt_time', '>=', Carbon::now()->subMinutes(30))
            ->where('locked_until', null)
            ->count();
    }
    
    
    private function resetAdminFailedAttempts($uuid)
    {
        PasswordAttempt::where('admin_id', $uuid)
            ->where('successful', false)
            ->update(['successful' => true]);
    }
    
    
    private function lockAdminAccount($uuid)
    {
        $lockUntil = Carbon::now()->addMinutes(30);
        
        PasswordAttempt::create([
            'admin_id' => $uuid,
            'attempt_time' => Carbon::now(),
            'successful' => false,
            'locked_until' => $lockUntil,
            'is_admin_locked' => 1
        ]);
        
        Auth('admin')->logout();
        return $lockUntil;
    }
    
    
    
    private function getAdminLockoutTime($uuid)
    {
        $lockRecord = PasswordAttempt::where('admin_id', $uuid)
            ->where('locked_until', '>', Carbon::now())
            ->orderBy('locked_until', 'desc')
            ->first();
            
        return $lockRecord ? $lockRecord->locked_until : null;
    }
    
    
     public function toggleBlockStatus($client_id)
    {
        try {
            $blockedAttempt = DB::table('password_attempts')
                ->where('client_id', $client_id)
                ->where('is_admin_locked', 1)  
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($blockedAttempt) {
                $client = \App\Models\Client::where('uuid', $client_id)->first();
                
                if (!$client) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Client user not found.'
                    ], 404);
                }
                
                // Clear all blocked attempts
                DB::table('password_attempts')
                    ->where('client_id', $client_id)
                    ->delete();
                    
                    
                 $client->force_password_reset = true;
                 $client->save();

                // Generate password reset token
                $token = Str::random(60);
                
                // Store token in password_resets table
                DB::table('password_resets')->updateOrInsert(
                    ['email' => $client->email],
                    ['token' => \Hash::make($token), 'created_at' => now()]
                );
                
                // Build reset link using client route
                $resetLink = route('client.password.reset', [
                    'token' => $token,
                    'email' => $client->email
                ]);
                
                // Send password reset notification
                $client->sendPasswordResetNotification($token);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Client account unblocked. Password reset instructions sent to ' . $client->email,
                    'data' => [
                        'email' => $client->email,
                        'reset_link' => $resetLink // For testing/logging purposes
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No blocked account record found for this client.'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error in toggleBlockStatus: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.'
            ], 500);
        }
    }
    
    public function toggleAdminBlockStatus($admin_id)
    {
        try {
            $blockedAttempt = DB::table('password_attempts')
                ->where('admin_id', $admin_id)
                ->where('is_admin_locked', 1)
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($blockedAttempt) {
                $admin = \App\Models\User::where('uuid', $admin_id)->first();
                
                if (!$admin) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Admin user not found.'
                    ], 404);
                }
                
                DB::table('password_attempts')
                    ->where('admin_id', $admin_id)
                    ->delete();
                    
                 $admin->force_password_reset = true;
                 $admin->save();

                $token = Str::random(60);
                DB::table('password_resets')->updateOrInsert(
                    ['email' => $admin->email],
                    ['token' => \Hash::make($token), 'created_at' => now()]
                );
                $resetLink = route('admin.password.reset', [
                    'token' => $token,
                    'email' => $admin->email
                ]);
                $admin->sendPasswordResetNotification($token);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Admin account unblocked. Password reset instructions sent to ' . $admin->email,
                    'data' => [
                        'email' => $admin->email,
                        'reset_link' => $resetLink 
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No blocked account record found for this admin.'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error in toggleAdminBlockStatus: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.'
            ], 500);
        }
    }
    
    
    public function manageState(){
        $perPage = request('per_page', 10);
        
         $states = DB::table('state')
        ->select('idnegeri', 'negeri', 'negeri_code', 'status')
       ->orderBy('idnegeri', 'desc')
        ->paginate($perPage);
        
        return view('settings.state-list', compact(
            'states', 
            'perPage', 
        ));
    }

    public function addState()
    {
        $validatedData = request()->validate([
            'negeri' => 'required|string|max:255|unique:state,negeri',
            'negeri_code' => 'required|string|max:11|unique:state,negeri_code',
            'status' => 'required|in:0,1'
        ]);

        try {
            DB::table('state')->insert([
                'negeri' => $validatedData['negeri'],
                'negeri_code' => $validatedData['negeri_code'],
                'status' => $validatedData['status']
            ]);

            return response()->json([
                'success' => true,
                'message' => trans('app.state_added_successfully')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('app.error_adding_state')
            ], 500);
        }
    }


    public function editState($id)
    {
        $validatedData = request()->validate([
            'negeri' => 'required|string|max:255|unique:state,negeri,' . $id . ',idnegeri',
            'negeri_code' => 'required|string|max:11|unique:state,negeri_code,' . $id . ',idnegeri',
            'status' => 'required|in:0,1'
        ]);

        try {
            DB::table('state')
                ->where('idnegeri', $id)
                ->update([
                    'negeri' => $validatedData['negeri'],
                    'negeri_code' => $validatedData['negeri_code'],
                    'status' => $validatedData['status']
                ]);

            return response()->json([
                'success' => true,
                'message' => trans('app.state_updated_successfully')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('app.error_updating_state')
            ], 500);
        }
    }
    
    
    public function manageLandCategory(){

        $perPage = request('per_page', 10);
        
         $landCategories = DB::table('land_category')
        ->select('id', 'category', 'rate', 'currency', 'status')
       ->orderBy('id', 'desc')
        ->paginate($perPage);
        
        return view('settings.land-category-list', compact(
            'landCategories', 
            'perPage', 
        ));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:250|unique:land_category,category',
            'rate' => 'required|numeric|min:0',
            'currency' => 'required|string|max:250',
            'status' => 'required|in:0,1',
        ], [
            'category.required' => 'Category name is required.',
            'category.unique' => 'This category already exists.',
            'category.max' => 'Category name must not exceed 250 characters.',
            'rate.required' => 'Rate is required.',
            'rate.numeric' => 'Rate must be a valid number.',
            'rate.min' => 'Rate must be greater than or equal to 0.',
            'currency.required' => 'Currency is required.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either Active or Inactive.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $landCategory = LandCategory::create([
                'category' => $request->category,
                'rate' => $request->rate,
                'currency' => $request->currency,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Land category added successfully',
                'data' => $landCategory
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding land category: ' . $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $landCategory = LandCategory::find($id);
        
        if (!$landCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Land category not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:250|unique:land_category,category,' . $id,
            'rate' => 'required|numeric|min:0',
            'currency' => 'required|string|max:250',
            'status' => 'required|in:0,1',
        ], [
            'category.required' => 'Category name is required.',
            'category.unique' => 'This category already exists.',
            'category.max' => 'Category name must not exceed 250 characters.',
            'rate.required' => 'Rate is required.',
            'rate.numeric' => 'Rate must be a valid number.',
            'rate.min' => 'Rate must be greater than or equal to 0.',
            'currency.required' => 'Currency is required.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either Active or Inactive.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $landCategory->update([
                'category' => $request->category,
                'rate' => $request->rate,
                'currency' => $request->currency,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Land category updated successfully',
                'data' => $landCategory
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating land category: ' . $e->getMessage()
            ], 500);
        }
    }



    public function destroy($id)
    {
        try {
            $landCategory = LandCategory::find($id);
            
            if (!$landCategory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Land category not found'
                ], 404);
            }

            $landCategory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Land category deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting land category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active land categories for dropdown/select options
     */
    public function getActiveCategories()
    {
        try {
            $categories = LandCategory::where('status', 1)
                ->orderBy('category', 'asc')
                ->get(['id', 'category', 'rate', 'currency']);

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching categories: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    
    public function manageDistrict()
    {
        $perPage = request('per_page', 10);

        $districts = DB::table('district')
            ->select('district.iddaerah', 'district.idnegeri', 'district.daerah', 'district.daerah_code', 'district.stat', 'state.negeri')
            ->join('state', 'district.idnegeri', '=', 'state.idnegeri')
            ->orderBy('district.iddaerah', 'desc')
            ->paginate($perPage);

        $states = DB::table('state')->where('status', 1)->get();

        return view('settings.district-list', compact(
            'districts',
            'perPage',
            'states'
        ));
    }

    public function addDistrict()
    {
        $validatedData = request()->validate([
            'idnegeri' => 'required|exists:state,idnegeri',
            'daerah' => 'required|string|max:100|unique:district,daerah',
            'daerah_code' => 'required|string|max:11|unique:district,daerah_code',
            'status' => 'required|in:0,1'
        ]);

        try {
            DB::table('district')->insert([
                'idnegeri' => $validatedData['idnegeri'],
                'daerah' => $validatedData['daerah'],
                'daerah_code' => $validatedData['daerah_code'],
                'stat' => $validatedData['status'] // Use 'stat' here
            ]);

            return response()->json([
                'success' => true,
                'message' => trans('app.district_added_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('app.error_adding_district')
            ], 500);
        }
    }

    public function editDistrict($id)
    {
        $validatedData = request()->validate([
            'idnegeri' => 'required|exists:state,idnegeri',
            'daerah' => 'required|string|max:100|unique:district,daerah,' . $id . ',iddaerah',
            'daerah_code' => 'required|string|max:11|unique:district,daerah_code,' . $id . ',iddaerah',
            'status' => 'required|in:0,1'
        ]);

        try {
            DB::table('district')
                ->where('iddaerah', $id)
                ->update([
                    'idnegeri' => $validatedData['idnegeri'],
                    'daerah' => $validatedData['daerah'],
                    'daerah_code' => $validatedData['daerah_code'],
                    'stat' => $validatedData['status'] // Use 'stat' here
                ]);

            return response()->json([
                'success' => true,
                'message' => trans('app.district_updated_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('app.error_updating_district')
            ], 500);
        }
    }
    
    
    public function manageDivision(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);

            $divisions = DB::table('division as div')
                ->leftJoin('district as d', 'div.daerah_id', '=', 'd.iddaerah')
                ->select(
                    'div.idmukim',
                    'div.daerah_id',
                    'div.mukim',
                    'div.mukim_code',
                    'div.status',
                    'd.daerah as district_name'
                )
                ->orderBy('div.idmukim', 'desc')
                ->paginate($perPage);

            $divisions->getCollection()->transform(function ($item) {
                $item->district = (object)['daerah' => $item->district_name];
                return $item;
            });

            $districts = DB::table('district')
                ->select('iddaerah', 'daerah')
                ->where('stat', 1) 
                ->orderBy('daerah', 'asc')
                ->get();

            return view('settings.division-list', compact('divisions', 'districts', 'perPage'));

        } catch (\Exception $e) {
            return back()->with('error', 'Error loading divisions: ' . $e->getMessage());
        }
    }



     public function addDivision(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'daerah_id' => 'required|integer|exists:district,iddaerah',
                'mukim' => 'required|string|max:255',
                'mukim_code' => 'required|string|max:255|unique:division,mukim_code',
                'status' => 'required|in:0,1'
            ], [
                'daerah_id.required' => 'District is required',
                'daerah_id.exists' => 'Selected district does not exist',
                'mukim.required' => 'Division name is required',
                'mukim.max' => 'Division name cannot exceed 255 characters',
                'mukim_code.required' => 'Division code is required',
                'mukim_code.max' => 'Division code cannot exceed 255 characters',
                'mukim_code.unique' => 'Division code already exists',
                'status.required' => 'Status is required',
                'status.in' => 'Status must be Active or Inactive'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $exists = DB::table('division')
                ->where('daerah_id', $request->daerah_id)
                ->where('mukim', $request->mukim)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Division name already exists in this district',
                    'errors' => [
                        'mukim' => ['Division name already exists in this district']
                    ]
                ], 422);
            }

            $divisionId = DB::table('division')->insertGetId([
                'daerah_id' => $request->daerah_id,
                'mukim' => trim($request->mukim),
                'mukim_code' => trim($request->mukim_code),
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Division added successfully',
                'data' => [
                    'id' => $divisionId
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding division: ' . $e->getMessage()
            ], 500);
        }
    }



    public function updateDivision(Request $request, $id)
    {
        try {
            $division = DB::table('division')->where('idmukim', $id)->first();
            
            if (!$division) {
                return response()->json([
                    'success' => false,
                    'message' => 'Division not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'daerah_id' => 'required|integer|exists:district,iddaerah',
                'mukim' => 'required|string|max:255',
                'mukim_code' => 'required|string|max:255|unique:division,mukim_code,' . $id . ',idmukim',
                'status' => 'required|in:0,1'
            ], [
                'daerah_id.required' => 'District is required',
                'daerah_id.exists' => 'Selected district does not exist',
                'mukim.required' => 'Division name is required',
                'mukim.max' => 'Division name cannot exceed 255 characters',
                'mukim_code.required' => 'Division code is required',
                'mukim_code.max' => 'Division code cannot exceed 255 characters',
                'mukim_code.unique' => 'Division code already exists',
                'status.required' => 'Status is required',
                'status.in' => 'Status must be Active or Inactive'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $exists = DB::table('division')
                ->where('daerah_id', $request->daerah_id)
                ->where('mukim', $request->mukim)
                ->where('idmukim', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Division name already exists in this district',
                    'errors' => [
                        'mukim' => ['Division name already exists in this district']
                    ]
                ], 422);
            }

            DB::table('division')
                ->where('idmukim', $id)
                ->update([
                    'daerah_id' => $request->daerah_id,
                    'mukim' => trim($request->mukim),
                    'mukim_code' => trim($request->mukim_code),
                    'status' => $request->status,
                    // 'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Division updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating division: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    public function manageSecurityQuestions()
    {
        $perPage = request('per_page', 10);
        
        $securityQuestions = DB::table('security_questions')
            ->select('id', 'question', 'question_key', 'question_type', 'status', 'created_at', 'updated_at')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        
        return view('settings.question-list', compact(
            'securityQuestions',
            'perPage'
        ));
    }



    public function addSecurityQuestion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'question' => 'required|string|max:255',
                'question_key' => 'required|string|max:50|unique:security_questions,question_key',
                'question_type' => 'required|in:primary,secondary',
                'status' => 'required|in:0,1'
            ], [
                'question.required' => 'Question field is required.',
                'question.max' => 'Question must not exceed 255 characters.',
                'question_key.required' => 'Question key field is required.',
                'question_key.max' => 'Question key must not exceed 50 characters.',
                'question_key.unique' => 'Question key already exists. Please use a different key.',
                'question_type.required' => 'Question type field is required.',
                'question_type.in' => 'Question type must be either primary or secondary.',
                'status.required' => 'Status field is required.',
                'status.in' => 'Status must be either active or inactive.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Insert the security question
            $result = DB::table('security_questions')->insert([
                'question' => trim($request->question),
                'question_key' => trim($request->question_key),
                'question_type' => $request->question_type,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Security question added successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add security question. Please try again.'
                ], 500);
            }

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error adding security question: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the security question. Please try again.'
            ], 500);
        }
    }


    public function updateSecurityQuestion(Request $request, $id)
    {
        try {
            $existingQuestion = DB::table('security_questions')->where('id', $id)->first();
            
            if (!$existingQuestion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Security question not found.'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'question' => 'required|string|max:255',
                'question_key' => 'required|string|max:50|unique:security_questions,question_key,' . $id,
                'question_type' => 'required|in:primary,secondary',
                'status' => 'required|in:0,1'
            ], [
                'question.required' => 'Question field is required.',
                'question.max' => 'Question must not exceed 255 characters.',
                'question_key.required' => 'Question key field is required.',
                'question_key.max' => 'Question key must not exceed 50 characters.',
                'question_key.unique' => 'Question key already exists. Please use a different key.',
                'question_type.required' => 'Question type field is required.',
                'question_type.in' => 'Question type must be either primary or secondary.',
                'status.required' => 'Status field is required.',
                'status.in' => 'Status must be either active or inactive.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update the security question
            $result = DB::table('security_questions')
                ->where('id', $id)
                ->update([
                    'question' => trim($request->question),
                    'question_key' => trim($request->question_key),
                    'question_type' => $request->question_type,
                    'status' => $request->status,
                    'updated_at' => now()
                ]);

            if ($result !== false) {
                return response()->json([
                    'success' => true,
                    'message' => 'Security question updated successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update security question. Please try again.'
                ], 500);
            }

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error updating security question: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the security question. Please try again.'
            ], 500);
        }

    }
    
    
    public function checkReferenceDuplicate(Request $request)
    {
        $referenceNo = $request->input('reference_no');
        $excludeId = $request->input('exclude_id'); // For edit forms
        
        // Query to check if reference exists
        $query = Application::where('refference_no', $referenceNo);
        
        // If this is an edit operation, exclude the current record
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $exists = $query->exists();
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Reference number already exists' : 'Reference number is available'
        ]);
    }
    
    
    public function trackClaimView(Request $request)
    {
        $claimId = $request->claim_id;
        
        DB::table('claim_contribution')
            ->where('id', $claimId)
            ->update(['is_viewed' => true]);
        
        return response()->json(['status' => 'success']);
    }
    
    public function trackApplicationView(Request $request)
    {
        $applicationId = $request->application_id;
        
        DB::table('applications')
            ->where('id', $applicationId)
            ->update(['is_approver_viewed' => true]);
        
        return response()->json(['status' => 'success']);
    }


    
    } 




