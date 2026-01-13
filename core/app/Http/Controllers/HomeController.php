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
use App\Models\ThirdPartyUser;
use App\Models\ReceiptRequest;
use App\Models\ClaimContribution;
use App\Models\Payment;
use App\Notifications\NewApplicationSent;
use App\Notifications\UserApplicationStatusNotification;
use App\Notifications\FinanceClaimNotification;
use App\Notifications\UserApplicationRejectionNotification;
use App\Notifications\ApproverClaimNotification;
use App\Notifications\ClaimStatusUpdated;
use App\Notifications\ReceiptStatusUpdated;
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
use Illuminate\Validation\Rule;

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
            ->select('land_district', DB::raw('count(*) as total'))
            ->groupBy('land_district')
            ->get();
            
        $districtCounts = DB::table('applications')
            ->select('land_district', DB::raw('count(*) as count'))
            ->groupBy('land_district')
            ->get();
            
        $districts = [];
        foreach ($districtCounts as $item) {
                $districtInfo = DB::table('district')
                    ->where('iddaerah', $item->land_district) // Using land_district now
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
            
            $query->whereIn('status', ['rejected', 'pending']);
            
            if ($request->has('status') && $request->status && $request->status !== '') {             
                if (in_array($request->status, ['rejected', 'pending'])) {
                    $query->where('status', $request->status);         
                }
            }
            
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
            

            $list = $query->orderBy('updated_at', 'desc')
                ->orderBy('created_at', 'desc')
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
            
            $district = DB::table('district')->where('stat', 1)
            ->where('idnegeri', 1)
            ->orderBy('daerah_code', 'asc')->get();                  
            
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


    public function approvedApplicationList( Request $request)
    {

        $isAuthenticated = auth('admin')->check();  
        $isAdminOrStaff = false;         
        if ($isAuthenticated) {             
            $roleId = auth('admin')->user()->role_id;             
            $isAdminOrStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');         
        } 
        $district = DB::table('district')->where('stat', 1)
        ->where('idnegeri', 1)
        ->orderBy('daerah_code', 'asc')->get();
       $query = Application::with(['state', 'landDistrict', 'landDivision', 'client']);

       $query->where('status', 'approved');

        if ($request->filled('search')) {
        $searchTerm = $request->get('search');
        $query->where(function($q) use ($searchTerm) {
                $q->where('refference_no', 'like', '%' . $searchTerm . '%')
                ->orWhere('applicant', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('client', function($clientQuery) use ($searchTerm) {
                    $clientQuery->where('name', 'like', '%' . $searchTerm . '%');
                });
            });
        }


            // District filter
        if ($request->filled('district')) {
            $query->where('land_district', $request->get('district'));
        }
        
        // Division filter  
        if ($request->filled('division')) {
            $query->where('land_state', $request->get('division'));
        }
        
        // Lot/PT filter
        if ($request->filled('lot')) {
            $query->where('land_lot', 'like', '%' . $request->get('lot') . '%');
        }


        // Year filter - ADD THIS
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->get('year'));
        }
        
        $perPage = $request->input('perPage', 10); 

        $approvedApplications = $query->orderBy('created_at', 'desc')
                                            ->paginate($perPage)
                                            ->appends($request->query());

        return view('application.approved_application_list', compact('approvedApplications', 'isAdminOrStaff', 'district'));
    }
    


    
    public function claimList(Request $request){
        $perPage = $request->input('per_page', 10);         
        $isAuthenticated = auth('admin')->check();                  
        $canAdminStaffViewApplication = auth('admin')->user()->hasPermission('applications.view-details');         
        $canAdminStaffEditClaimApplication = auth('admin')->user()->hasPermission('claim-contribution.edit');                  
        $isAdminOrStaff = false;         
        $financeStaff = false;
        
        if ($isAuthenticated) {             
            $roleId = auth('admin')->user()->role_id;             
            $isAdminOrStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa'); 
            $financeStaff = ($roleId === '9e032970-5f48-4d2b-b88e-abb9da79140f'); 
            $isApplicationApprover = ($roleId === '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d');      
        }                  

        // Build the query WITHOUT ->get()
        $query = ClaimContribution::with(['state', 'landDistrict', 'landDivision', 'client'])
            ->where('status', '!=', 'approve_paid');
        
        if ($financeStaff) {
            $query->where('send_to_finance', 1);
        }

        if ($isApplicationApprover){
            $query->where('sent_to_approver', 1);
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
        
        if ($request->has('status') && $request->status && $request->status !== 'all') {             
            $query->where('status', $request->status);         
        }    

        // Get the paginated results with ordering - call ->get() or ->paginate() at the END
        $list = $query->orderBy('updated_at', 'desc')
            ->paginate($perPage)
            ->appends($request->except('page'));

        // Get current user ID for highlighting
        $currentUserId = auth('admin')->id();

        $district = DB::table('district')->where('stat', 1)
            ->where('idnegeri', 1)
            ->orderBy('daerah_code', 'asc')->get(); 

        $statuses = [
            'all' => 'Semua',
            'pending' => 'Belum Selesai',
            'approve_paid' => 'Lulus-Sudah Bayar',
            'rejected' => 'Ditolak'
        ];
        
        return view('claim.claim-contribution-list', compact(
            'list',              
            'district',              
            'perPage',              
            'isAdminOrStaff', 
            'financeStaff',             
            'canAdminStaffViewApplication',
            'statuses',              
            'canAdminStaffEditClaimApplication',
            'currentUserId',
            'isApplicationApprover'
        ));
    }


     public function approvedClaimList(Request $request){
        $perPage = $request->input('per_page', 10);         
        $isAuthenticated = auth('admin')->check();                  
        $canAdminStaffViewApplication = auth('admin')->user()->hasPermission('applications.view-details');         
        $canAdminStaffEditClaimApplication = auth('admin')->user()->hasPermission('claim-contribution.edit');                  
        $isAdminOrStaff = false;         
        $financeStaff = false;
        if ($isAuthenticated) {             
            $roleId = auth('admin')->user()->role_id;             
            $isAdminOrStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa'); 
            $financeStaff = ($roleId === '9e032970-5f48-4d2b-b88e-abb9da79140f');       
        }                  

        $query = ClaimContribution::with(['state', 'landDistrict', 'landDivision', 'client'])
        ->where('status', 'approve_paid'); 
    

        if ($request->has('district') && $request->district) {             
            $query->where('land_district', $request->district);         
        }                  

        if ($request->has('division') && $request->division) {             
            $query->where('land_state', $request->division);         
        }                  

        if ($request->has('lot') && $request->lot) {             
            $query->where('land_lot', 'LIKE', '%' . $request->lot . '%');         
        }   
        
        if ($request->has('status') && $request->status && $request->status !== 'all') {             
            $query->where('status', $request->status);         
        }    

        // Get the paginated results with activity tracking
        $list = $query->orderBy('verified_date', 'desc')
            ->paginate($perPage)
            ->appends($request->except('page'));

        // Get current user ID for highlighting
        $currentUserId = auth('admin')->id();

        $district = DB::table('district')->where('stat', 1)
        ->where('idnegeri', 1)
        ->orderBy('daerah_code', 'asc')->get(); 

        $statuses = [
            'all' => 'Semua',
            'pending' => 'Belum Selesai',
            'approve_paid' => 'Lulus-Sudah Bayar',
            'rejected' => 'Ditolak'
        ];
        
        return view('claim.approved-claim-list', compact( 'list',              
            'district',              
            'perPage',              
            'isAdminOrStaff', 
            'financeStaff',             
            'canAdminStaffViewApplication',
            'statuses',              
            'canAdminStaffEditClaimApplication',
            'currentUserId'));
    }
    
    
    public function claimView(Request $request, $id)
    {
        try {
            
            $isAuthenticated = auth('admin')->check();
            $isAdminStaff = false;
            $isFinanceStaff = false;
            if ($isAuthenticated) {
                $roleId = auth('admin')->user()->role_id;
                $isAdminStaff = ($roleId === '9e032984-8ef0-4e00-b7b9-439679a4d1aa');
                $isFinanceStaff= ($roleId === '9e032970-5f48-4d2b-b88e-abb9da79140f');
                $isApplicationApprover= ($roleId === '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d');
            }
            $claim = ClaimContribution::with(['state', 'landDistrict', 'landDivision', 'client'])
                ->findOrFail($id);
            
            $state = DB::table('state')->where('status', 1)->orderBy('negeri_code', 'asc')->get();
            $district = DB::table('district')->where('stat', 1)
            ->orderBy('daerah_code', 'asc')->get();
            $division = DB::table('division')->where('status', 1)->orderBy('mukim_code', 'asc')->get();
            $landMeasurement = DB::table('land_measurement_unit')->get();

            return view('claim.edit-claim-contribution', compact(
                'claim',
                'state',
                'district',
                'landMeasurement',
                'division',
                'isAdminStaff',
                'isFinanceStaff',
                'isApplicationApprover'
            ));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Claim not found or an error occurred.');
        }
    }


    public function claimSendToApprover($id)
    {
        try {
            DB::beginTransaction();
            
            $claim = DB::table('claim_contribution')
                ->where('id', $id)
                ->first();

            if (!$claim) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tuntutan tidak dijumpai'
                ], 404);
            }

            // Allow resending if rejected, otherwise check if already sent
            if ($claim->sent_to_approver == 1 && $claim->status !== 'rejected') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tuntutan ini telah dihantar ke pelulus'
                ], 400);
            }

            if (in_array($claim->status, ['approve_paid'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tuntutan ini tidak boleh dihantar ke pelulus'
                ], 400);
            }

            // Get admin user information
            $admin = auth('admin')->user();
            $causerUsername = $admin ? $admin->username : 'System';
            $causerUuid = $admin ? $admin->uuid : null;

            // Prepare update data
            $updateData = [
                'sent_to_approver' => 1,
                'sent_to_approver_at' => now(),
                'sent_to_approver_by' => $causerUsername,
                'updated_at' => now()
            ];

            // If claim was rejected, reset status and clear rejection fields
            if ($claim->status === 'rejected') {
                $updateData['status'] = 'pending';
                $updateData['rejected_reason'] = null;
                $updateData['rejected_by'] = null;
                $updateData['rejected_by_role'] = null;
            }

            // Update the claim
            DB::table('claim_contribution')
                ->where('id', $id)
                ->update($updateData);

            // Fetch updated claim after update
            $updatedClaim = DB::table('claim_contribution')->where('id', $id)->first();

            // Log activity
            $activityDescription = 'Claim sent to approver by admin: ' . $causerUsername;
            if ($claim->status === 'rejected') {
                $activityDescription .= ' (Resent after rejection - Status changed to pending)';
            }

            ActivityLog::create([
                'log_name' => 'claim_contribution',
                'description' => $activityDescription,
                'event' => $claim->status === 'rejected' ? 'resent_to_approver' : 'sent_to_approver',
                'subject_type' => 'App\Models\ClaimContribution',
                'subject_id' => $id,
                'properties' => [
                    'sent_to_approver' => 1,
                    'previous_status' => $claim->status,
                    'new_status' => $claim->status === 'rejected' ? 'pending' : $claim->status
                ],
                'causer_type' => $admin ? get_class($admin) : null,
                'causer_id' => $causerUuid,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Send notification to approver staff
            try {
                // Replace with your actual approver role_id
                $approverStaff = User::where('role_id', '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d')->get();
                
                if ($approverStaff->isNotEmpty()) {
                    foreach ($approverStaff as $approver) {
                        // Check if notification already exists for this resend
                        $existingNotification = $approver->notifications()
                            ->where('type', 'App\Notifications\ApproverClaimNotification')
                            ->whereJsonContains('data->claim_id', $id)
                            ->where('read_at', null) // Only check unread notifications
                            ->first();
                        
                        if (!$existingNotification) {
                            $approver->notify(new ApproverClaimNotification($updatedClaim, $causerUsername, $claim->status === 'rejected'));
                        }
                    }
                }
            } catch (\Exception $notificationError) {
                \Log::error('Error notifying approver staff about claim: ', [
                    'claim_id' => $id,
                    'message' => $notificationError->getMessage(),
                    'trace' => $notificationError->getTraceAsString()
                ]);
            }

            DB::commit();

            $message = 'Tuntutan berjaya dihantar ke pelulus';
            if ($claim->status === 'rejected') {
                $message = 'Tuntutan yang ditolak berjaya dihantar semula ke pelulus';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ralat sistem: ' . $e->getMessage()
            ], 500);
        }  
    }

    
    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,approve_payment_in_process,rejected,approve_paid,check_query',
                'payment_amount' => 'nullable|numeric|min:0',
                'process_remarks' => 'nullable|string|max:1000',
                'payment_remarks' => 'nullable|string|max:1000',
                'visit_date' => 'nullable|date',
                'verification_date' => 'nullable|date',
                'reason' => 'nullable|string|max:500',
                'eft_no' => 'nullable|string|max:100',
                'query_date' => 'nullable|date',
                'query_remarks' => 'nullable|string|max:1000',
                'payment_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            ]);

            $claim = DB::table('claim_contribution')->where('id', $id)->first();
            if (!$claim) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tuntutan tidak dijumpai'
                ], 404);
            }

            $oldData = (array) $claim;
            $oldStatus = $claim->status;

            // Get admin user information
            $admin = auth('admin')->user();
            $causerUsername = $admin ? $admin->username : 'System';
            $causerUuid = $admin ? $admin->uuid : null;

            // Determine role for rejection
            $rejectedByRole = 'admin_staff'; // default
            if ($admin && isset($admin->role_id)) {
                if ($admin->role_id == '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d') {
                    $rejectedByRole = 'approver';
                }
            }

            $updateData = [
                'status' => $request->status,
                'updated_at' => now()
            ];
            
            // Handle approve_paid status fields
            if ($request->hasFile('payment_document')) {
                if ($claim->payment_document && file_exists(public_path($claim->payment_document))) {
                    unlink(public_path($claim->payment_document));
                }

                // Define upload path
                $uploadPath = public_path('pdf');
                
                // Create directory if it doesn't exist
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file = $request->file('payment_document');
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileExtension = $file->getClientOriginalExtension();
                $newFileName = $fileName . '_' . time() . '.' . $fileExtension;

                // Move the file to the upload directory with the new name
                $file->move($uploadPath, $newFileName);

                // Store the new file path
                $updateData['payment_document'] = 'pdf/' . $newFileName;
            }

            // Update rejection tracking
            if ($request->status === 'rejected') {
                if ($request->filled('reason')) {
                    $updateData['rejected_reason'] = $request->reason;
                }
                $updateData['rejected_by'] = $causerUsername;
                $updateData['rejected_by_role'] = $rejectedByRole;
                $updateData['sent_to_approver'] = 0;
                $updateData['sent_to_approver_by'] = NULL;
            }

            if ($request->status === 'pending' || $request->status === 'approve_payment_in_process') {
                if ($request->filled('visit_date')) {
                    $updateData['visit_date'] = $request->visit_date;
                }

                if ($request->filled('process_remarks')) {
                    $updateData['process_remarks'] = $request->process_remarks;
                }
            }

            if ($request->status === 'check_query') {
                if ($request->filled('query_date')) {
                    $updateData['query_date'] = $request->query_date;
                }

                if ($request->filled('query_remarks')) {
                    $updateData['query_remarks'] = $request->query_remarks;
                }
                
                // ADD THIS DEBUG LOG
                \Log::info('Check Query Update Data:', [
                    'updateData' => $updateData,
                    'query_date' => $request->query_date,
                    'query_remarks' => $request->query_remarks,
                    'request_all' => $request->all()
                ]);
            }


           // Add payment amount if status is approve_paid
            if ($request->status === 'approve_paid' && $request->payment_amount) {
                $updateData['payment_amount'] = $request->payment_amount;
            }

            if ($request->status === 'approve_paid' && $request->eft_no) {
                $updateData['eft_no'] = $request->eft_no;
            }

            if ($request->status === 'approve_paid' && $request->verification_date) {
                $updateData['verified_date'] = $request->verification_date;
            }

            if ($request->status === 'approve_paid' && $request->payment_remarks) {
                $updateData['payment_remarks'] = $request->payment_remarks;
            }

            DB::table('claim_contribution')
                ->where('id', $id)
                ->update($updateData);

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

            $activityDescription = 'Claim status updated by admin: ' . $causerUsername . ' from "' . $oldStatus . '" to "' . $request->status . '"';
            
            if ($request->status === 'rejected') {
                $activityDescription = 'Claim rejected by ' . $rejectedByRole . ': ' . $causerUsername;
                if ($request->filled('reason')) {
                    $activityDescription .= ' - Reason: ' . $request->reason;
                }
            } elseif ($request->status === 'check_query') {
                $activityDescription = 'Claim status set to Query by admin: ' . $causerUsername;
                if ($request->filled('query_remarks')) {
                    $activityDescription .= ' - Query: ' . $request->query_remarks;
                }
            }

            ActivityLog::create([
                'log_name' => 'claim_contribution',
                'description' => $activityDescription,
                'event' => $request->status === 'rejected' ? 'rejected' : 'status_updated',
                'subject_type' => 'App\Models\ClaimContribution',
                'subject_id' => $id,
                'properties' => $changes,
                'causer_type' => $admin ? get_class($admin) : null,
                'causer_id' => $causerUuid,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Send notification
            try {
                \Log::info('Sending claim status notification:', [
                    'claim_id' => $id,
                    'user_id' => $claim->user_id,
                    'status' => $request->status
                ]);

                $client = ClientRegisterModel::where('client_id', $claim->user_id)->first();
                
                if (!$client) {
                    \Log::warning('No client found for claim', [
                        'claim_id' => $id,
                        'user_id' => $claim->user_id
                    ]);
                } else {
                    $user_client = ClientUser::where('uuid', $claim->user_id)->first();
                    
                    if ($user_client) {
                        $claimModel = ClaimContribution::find($id);
                        $user_client->notify(new ClaimStatusUpdated($claimModel, $oldStatus));
                        
                        \Log::info('Notification sent to client', [
                            'claim_id' => $id,
                            'client_id' => $client->client_id,
                            'user_uuid' => $user_client->uuid,
                            'status' => $request->status
                        ]);
                    } else {
                        \Log::warning('User client not found', [
                            'claim_id' => $id,
                            'user_id' => $claim->user_id
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send claim status notification: ', [
                    'claim_id' => $id,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            $successMessage = 'Status tuntutan berjaya dikemaskini';
            if ($request->status === 'rejected') {
                $successMessage = 'Tuntutan berjaya ditolak';
            } elseif ($request->status === 'approve_paid') {
                $details = [];
                if ($request->payment_amount) {
                    $details[] = 'jumlah bayaran RM ' . number_format($request->payment_amount, 2);
                }
                if ($request->eft_no) {
                    $details[] = 'No. EFT: ' . $request->eft_no;
                }
                if (!empty($details)) {
                    $successMessage .= ' dengan ' . implode(' dan ', $details);
                }
            }

            return response()->json([
                'success' => true,
                'message' => $successMessage
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Errors: ', $e->errors());
            
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Pengesahan gagal. Sila semak input anda.'
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Update Status Error: ' . $e->getMessage());
            Log::error('Stack Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Ralat tidak dijangka berlaku. Sila cuba lagi.'
            ], 500);
        }
    }


    public function sendToFinance(Request $request, $id)
    {
        try {
            $claim = DB::table('claim_contribution')->where('id', $id)->first();

            if (!$claim) {
                return response()->json(['success' => false, 'message' => 'Claim not found'], 404);
            }

            $admin = auth('admin')->user();
            $causerUsername = $admin ? $admin->username : 'System';
            $causerUuid = $admin ? $admin->uuid : null;

            // Update the send_to_finance flag
            DB::table('claim_contribution')
                ->where('id', $id)
                ->update([
                    'send_to_finance' => 1,
                    'sent_by' => $causerUsername,
                    'sent_to_finance_at' => now(),
                    'updated_at' => now(),
                ]);

            // Fetch updated claim after update
            $updatedClaim = DB::table('claim_contribution')->where('id', $id)->first();

            ActivityLog::create([
                'log_name' => 'claim_contribution',
                'description' => 'Claim sent to finance by admin: ' . $causerUsername,
                'event' => 'sent_to_finance',
                'subject_type' => 'App\Models\ClaimContribution',
                'subject_id' => $id,
                'properties' => ['send_to_finance' => 1],
                'causer_type' => $admin ? get_class($admin) : null,
                'causer_id' => $causerUuid,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Send notification to finance staff
            try {
                $financeStaff = User::where('role_id', '9e032970-5f48-4d2b-b88e-abb9da79140f')->get();
                
                if ($financeStaff->isNotEmpty()) {
                    foreach ($financeStaff as $finance) {
                        // Check if notification already exists
                        $existingNotification = $finance->notifications()
                            ->where('type', 'App\Notifications\FinanceClaimNotification')
                            ->whereJsonContains('data->claim_id', $id)
                            ->first();
                        
                        if (!$existingNotification) {
                            $finance->notify(new FinanceClaimNotification($updatedClaim, $causerUsername));
                        }
                    }
                }
            } catch (\Exception $notificationError) {
                \Log::error('Error notifying finance staff about claim: ', [
                    'claim_id' => $id,
                    'message' => $notificationError->getMessage(),
                    'trace' => $notificationError->getTraceAsString()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => __('Permohonan berjaya dihantar ke Bahagian Kewangan')
            ]);
        } catch (\Exception $e) {
            \Log::error('Send to Finance Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 500);
        }
    }



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
            ->where('forwarded_by_admin_staff', 1)
            ->whereIn('status', ['pending', 'rejected']);
    
        // Add status filter
        if ($request->has('status') && $request->status && $request->status !== '') {
            if (in_array($request->status, [ 'rejected', 'pending'])) {
                $query->where('status', $request->status);
            } elseif ($request->status === 'appeal') {
                $query->where('appeal', 'yes')
                    ->where('appeal_status', 'approved');
            } elseif ($request->status === 'resubmitted') {
                $query->whereNotNull('resubmitted_at');
            }
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
    
        $list = $query->orderBy('updated_at', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage)
                ->appends($request->except('page'));
            
        $district = DB::table('district')->where('stat', 1)
        ->where('idnegeri', 1)
        ->orderBy('daerah_code', 'asc')->get();
        
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

            $selectedStateId = $request->input('state');
            $isDistrictRequired = true;

            if ($selectedStateId) {
                $state = DB::table('state')->where('idnegeri', $selectedStateId)->first();
                
                if ($state) {
                    $stateCode = (int)$state->negeri_code;
                    $exemptStateCodes = [14, 15, 16];
                    $isDistrictRequired = !in_array($stateCode, $exemptStateCodes);
                }
            }

            // Define base validation rules
            $validationRules = [
                "uploade_date" => "required",
                "refference_no" => "nullable|string|unique:applications,refference_no,".$id,
                "applicant" => "required",
                "address" => "required",
                // "postal_code" => "required|numeric|digits:6",
                "phone" => "numeric|digits_between:10,15",
                "email" => "required|email",
                "state" => "nullable",
                "city" => "required",
                "land_lot" => "required",
                "land_area" => "required",
                "land_district" => "nullable",
                "land_state" => "nullable",
                "land_category" => "nullable",
                "hectare" => "nullable|numeric",
                "base_amount" => "nullable|numeric",
                "adjustment_percentage" => "nullable|numeric",
                "discount_amount" => "nullable|numeric",
                "final_amount" => "nullable|numeric",
                "cost" => "nullable|numeric",
                "appeal" => "nullable|in:yes,no",
                "appeal_letter" => "nullable|file|mimes:pdf,jpg,jpeg,png|max:15000",
                "remark" => "nullable|string|max:255",
            ];

            $applicantType = $application->applicant_type ?? $request->input('applicant_type');

            if ($isDistrictRequired) {
                $validationRules["district"] = "nullable";
            }

            if ($applicantType != 3) {
                $validationRules['identities'] = 'required';
            } else {
                $validationRules['identities'] = 'nullable';
            }

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
        
            foreach (['land_grant', 'permission_plan', 'letter_of_support', 'appeal_letter'] as $fileKey) {
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
                "project_name" => $request->input('project_name'),
                "appeal_status" => $request->input('appeal') === 'yes' ? 'approved' : 'rejected'
            ];

            if ($isDistrictRequired) {
                $updateData["district"] = $request->input('district', $application->district);
            } else {
                $updateData["district"] = $request->input('district') ?: null;
            }
            
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
            $approvers = User::where('role_id', $approverRoleId)->get();

            if (!$approvers) {
                Log::warning('No approver found', ['role_id' => $approverRoleId]);
                return response()->json(['success' => false, 'message' => 'No approver found'], 404);
            }

            foreach ($approvers as $approver) {
                $approver->notify(new NewApplicationSent($application));
            }

            
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
        $canAdminStaffViewCustomerDetails = auth('admin')->user()->hasPermission('pemohon.view');
        $canAdminStaffEditCustomerDetails = auth('admin')->user()->hasPermission('pemohon.edit');
        $canAdminStaffDeleteCustomer = auth('admin')->user()->hasPermission('pemohon.delete');

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
            
        $district = DB::table('district')->where('stat', 1)
        ->where('idnegeri', 1)
        ->orderBy('daerah_code', 'asc')->get();
        $account_types = DB::table('account_types')->get();
            
        return view('application.developer_list', compact(
            'client_register',
            'district',
            'account_types',
            'perPage',
            'isAdminOrStaff',
            'canAdminStaffViewCustomerDetails',
            'canAdminStaffEditCustomerDetails',
            'canAdminStaffDeleteCustomer'
        ));
    }

    public function destroy_user($id)
    {
        try {
            DB::beginTransaction();
            $clientRegister = ClientRegisterModel::findOrFail($id);
            $clientId = $clientRegister->client_id;
            $clientRegister->delete();
            
            if ($clientId) {
                 ClientUser::where('uuid', $clientId)->delete();
            }
        
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Client deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            // Rollback the transaction if anything fails
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete client: ' . $e->getMessage()
            ], 500);
        }
    }


    
    
    
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
            'landDistrict',
            'landDivision',
            'logs' => function($query) {
                $query->orderBy('action_at', 'desc');
            }
        ])
        ->whereIn('status', ['pending', 'rejected', 'returned_to_staff'])
        ->orderBy('updated_at', 'desc');    
        
        
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
        if ($statusFilter && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }


        if ($request->filled('district')) {
            $query->where('land_district', $request->get('district'));
        }
        
        // Division filter  
        if ($request->filled('division')) {
            $query->where('land_state', $request->get('division'));
        }
        
        // Lot/PT filter
        if ($request->filled('lot')) {
            $query->where('land_lot', 'like', '%' . $request->get('lot') . '%');
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
        
        $district = DB::table('district')->where('stat', 1)
        ->where('idnegeri', 1)
        ->orderBy('daerah_code', 'asc')->get();

        if ($isApproverAdmin) {
            $query->where('forwarded_by_admin_staff', 1);
        }
        
        $applications = $query->paginate($perPage);                  
        
        return view('application.application-status', compact(             
            'applications',              
            'allCount',  
            'district',            
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
            'payment_method' => 'required|in:online,cheque,bank_draf',
            'payment_status' => 'required|in:completed,pending,failed,in_review',
            'receipt_number' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string',
            'cheque_number' => 'required_if:payment_method,cheque|string|max:255',
            'cheque_date' => 'required_if:payment_method,cheque|date',
            'bank_name' => 'required_if:payment_method,cheque|string|max:255',
            'deposit_date' => 'nullable|date',
            'transaction_id' => 'required_if:payment_method,bank_draf|string|max:255',
            'transfer_date' => 'required_if:payment_method,bank_draf|date',
            'amount' => 'required_if:payment_method,bank_draf|numeric',
            'account_number' => 'nullable|string|max:255',
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
        // $bankTransferReceiptPath = null;
        // if ($request->hasFile('receipt_upload') && $request->payment_method === 'bank_transfer') {
        //     $bankTransferReceiptPath = $request->file('receipt_upload')->store('bank_receipts', 'public');
        // }

        // Generate transaction ID based on payment method
        $transactionId = null;
        switch ($validated['payment_method']) {
            case 'online':
                $transactionId = $request->gateway_transaction_id
                    ?? $request->transaction_id
                    ?? 'ONL-'.mt_rand(1000000000,9999999999);
                break;
        
            case 'bank_draf':
                $transactionId = $request->transaction_id
                    ? 'BD-'.$request->transaction_id
                    : 'BD-'.mt_rand(1000000000,9999999999);
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
                
            case 'bank_draf':
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


        if ($validated['payment_method'] === 'cheque' ) {
            $paymentAmount = $application->final_amount;
        } else {
            $paymentAmount = $request->amount;
        }

        $payment = Payment::updateOrCreate(
            ['application_id' => $application->id],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'application_id' => $application->id,
                'payment_date' => $paymentDate,
                'amount' => $paymentAmount,
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
        $list = $this->fetchApprovedApplicationsForPayment($request);
        $perPage = $request->input('per_page', 10);
        $statusFilter = $request->input('status', 'all'); // Add this line

        $isFinanceAdmin = $this->isFinanceAdmin();
        $isFinanceApprover = $this->isFinanceApprover();

        return view('application.view-receipt', compact(
            'list', 
            'perPage',
            'statusFilter', // Add this line
            'isFinanceAdmin',
            'isFinanceApprover'
        ));     
    }


    private function fetchApprovedApplicationsForPayment(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('q');
        $statusFilter = $request->input('status', 'all');

        $query = Application::with([
                'state', 
                'landDistrict', 
                'landDivision', 
                'client',
                'payment'
            ]);

        // Only approved applications
        $query->where('status', 'approved');

        // Apply status filter
        if ($statusFilter === 'in_review') {
            $query->whereHas('payment', function($paymentQuery) {
                $paymentQuery->where('payment_status', 'in_review');
            });
        } elseif ($statusFilter === 'belum_bayar') {
            $query->whereDoesntHave('payment');
        } elseif ($statusFilter === 'all') {
            $query->where(function($q) {
                $q->whereDoesntHave('payment')
                ->orWhereHas('payment', function($paymentQuery) {
                    $paymentQuery->where('payment_status', 'in_review');
                });
            });
        }

        // Order by latest
        $query->orderBy('created_at', 'desc');

        // Apply search filter if provided
        if ($search) {
            $like = "%{$search}%";
            $query->where(function ($sub) use ($like) {
                $sub->where('refference_no', 'like', $like)
                    ->orWhere('applicant', 'like', $like)
                    ->orWhere('land_lot', 'like', $like)
                    ->orWhere('final_amount', 'like', $like)
                    ->orWhereHas('client', function($clientQuery) use ($like) {
                        $clientQuery->where('userName', 'like', $like);
                    });
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    private function isFinanceAdmin(): bool
    {
        return auth('admin')->check() &&
            auth('admin')->user()->role_id === '9e032970-5f48-4d2b-b88e-abb9da79140f';
    }

    private function isFinanceApprover(): bool
    {
        return auth('admin')->check() &&
            auth('admin')->user()->role_id === '27f41653-a968-4885-8000-7aaf4efc385d';
    }




 
    private function fetchPayments(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $statusFilter = $request->input('status_filter', 'all'); 
        $methodFilter = $request->input('method_filter', 'all'); 
        $search = $request->input('q');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        
        $query = Payment::with([
                'application.state', 
                'application.landDistrict', 
                'application.landDivision', 
                'application.client'
            ])
            ->where('payment_status', 'completed') 
            ->whereHas('application', function($appQuery) {
                $appQuery->where('status', 'approved');
            })
            ->orderBy('created_at', 'desc');
        // Apply status filter
        if ($statusFilter !== 'all') {
            if (in_array($statusFilter, ['completed','failed','pending','pending_authorization','in_review'])) {
                $query->where('payment_status', $statusFilter);
            }
        }
        
        // Apply method filter
        if ($methodFilter !== 'all') {
            $methodMapping = [
                'B2B' => 'FPX_B2B',
                'B2C' => 'FPX_B2C',
                'EFT' => 'EFT',
                'Cheque' => 'cheque',
                'Bank Transfer' => 'bank_transfer',
            ];

            if ($methodFilter === 'BAUCAR BAYARAN') {
                $query->where('method', 'EFT')
                    ->whereHas('application.client', function($clientQuery) {
                        $clientQuery->where('accountType', 3);
                    });
            } elseif ($methodFilter === 'EFT') {
                $query->whereIn('method', ['EFT', 'FPX_B2B', 'FPX_B2C']);
            } else {
                $exactMethod = $methodMapping[$methodFilter] ?? null;
                if ($exactMethod) {
                    $query->where('method', '=', $exactMethod);
                }
            }
        }

        // Apply date filter
        if ($dateFrom || $dateTo) {
            if ($dateFrom) {
                $query->whereDate('payment_date', '>=', $dateFrom);
            }
            
            if ($dateTo) {
                $query->whereDate('payment_date', '<=', $dateTo);
            }
        }

        // Apply search filter
        if ($search) {
            $like = "%{$search}%";
            $query->where(function ($sub) use ($like) {
                $sub->whereHas('application', function($appQuery) use ($like) {
                    $appQuery->where('refference_no', 'like', $like)
                            ->orWhere('applicant', 'like', $like)
                            ->orWhere('land_lot', 'like', $like)
                            ->orWhere('final_amount', 'like', $like);
                })->orWhereHas('application.client', function($clientQuery) use ($like) {
                    $clientQuery->where('userName', 'like', $like);
                });
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function paymentsList(Request $request)
    {
        $list = $this->fetchPayments($request);
        
        $perPage = $request->input('per_page', 10);
        $statusFilter = $request->input('status_filter', 'all');
        $methodFilter = $request->input('method_filter', 'all');
        
        // $canApproverViewReciept = auth('admin')->user()->hasPermission('payments.view-details');

        return view('application.payments-list', compact(
            'list', 
            'perPage', 
            'statusFilter',
            'methodFilter',
        ));
    }
    
    public function userReceipt(){
        $list = Application::with(['state', 'landDistrict', 'landDivision', 'client'])
            ->latest()
            ->paginate($perPage);
        return view('application.user-receiptoriginal', compact('list'));
    }
    
    
    public function userReceiptView($application_id, $payment_uuid)     
    {         
        $application = Application::select(
                'applications.*',
                'state.negeri',
                'district.daerah'
            )
            ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
            ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
            ->where('applications.id', $application_id)
            ->firstOrFail();
        
        // Get the SPECIFIC payment record by uuid column
        $completedPayment = $application->payment()
            ->where('uuid', $payment_uuid) // Using uuid column instead of id
            ->where('payment_status', 'completed')
            ->firstOrFail();
        
        if ($completedPayment) {
            $application->payment_status = $completedPayment->payment_status;
            $application->payment_method = $completedPayment->method;
            $application->payment_type = $completedPayment->payment_type; // 'reprint' or null/other
            $application->payment_amount = $completedPayment->amount;
            $application->transaction_id = $completedPayment->transaction_id;
            $application->receipt_number = $completedPayment->receipt_number;
            $application->payment_date = $completedPayment->created_at;
            $application->gateway_response = $completedPayment->gateway_response;
            $application->buyer_name = $completedPayment->buyer_name;
            $application->buyer_email = $completedPayment->buyer_email;


            if ($completedPayment->thirdParty) {
                $application->third_party_id_card = $completedPayment->thirdParty->id_card_number;
                $application->third_party_name = $completedPayment->thirdParty->name;
                $application->third_party_email = $completedPayment->thirdParty->email;
                $application->third_party_address = $completedPayment->thirdParty->address;
            }
            
            if ($completedPayment->gateway_response) {
                $gatewayResponse = is_array($completedPayment->gateway_response) 
                    ? $completedPayment->gateway_response 
                    : json_decode($completedPayment->gateway_response, true);
                if (isset($gatewayResponse['fpx_response_data']['fpx_fpxTxnTime'])) {
                    $fpxTime = $gatewayResponse['fpx_response_data']['fpx_fpxTxnTime'];
                    
                    $formattedTime = \Carbon\Carbon::createFromFormat('YmdHis', $fpxTime)
                        ->format('d/m/Y h:i:s A');
                    
                    $application->fpx_payment_time = $formattedTime;
                }
                elseif (isset($gatewayResponse['processed_at'])) {
                    $formattedTime = \Carbon\Carbon::parse($gatewayResponse['processed_at'])
                        ->setTimezone('Asia/Kuala_Lumpur')
                        ->format('d/m/Y h:i:s A');
                    
                    $application->fpx_payment_time = $formattedTime;
                }
            }
        }
        
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
                'payments.bank_name',
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
                'totalAmountRaw' => $totalAmount,
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
            ->where('idnegeri', 1)
            ->where('stat', 1)
            ->orderBy('daerah_code', 'asc')
            ->get();
            
        $applicants = ClientRegisterModel::select('client_id', 'userName')->get();
        
        // ✅ FIX: Remove duplicate lot numbers efficiently
        $lotPts = Application::select('land_lot')
            ->whereNotNull('land_lot')
            ->where('land_lot', '!=', '')
            ->groupBy('land_lot')
            ->orderBy('land_lot', 'asc')
            ->get()
            ->map(function($item) {
                return (object)[
                    'lot_number' => $item->land_lot
                ];
            });
            
        $results = collect();  
        
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
            
            // ✅ FIX: Add pagination to prevent memory exhaustion
            $results = $query->with(['applicant', 'division', 'districts', 'payment'])
                ->orderBy('created_at', 'desc')
                ->paginate(50);  // Show 50 results per page
            
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

    // Fetch security questions
    $securityQuestion1 = DB::table('security_questions')
        ->where('question_key', $ClientRegister->securityQuestion1)
        ->value('question');

    $securityQuestion2 = DB::table('security_questions')
        ->where('question_key', $ClientRegister->securityQuestions2)
        ->value('question');

    return view('admin.user-details-update', compact('title', 'ClientRegister', 'states', 'districts', 'securityQuestion1', 'securityQuestion2'));
}

public function updateUserDetails(Request $request, $id)
{
    try {

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
    
    
    public function updatePassword(Request $request, $uuid)
    {
        try {
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
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%])[A-Za-z\d!@#$%]{8,20}$/',
                    'different:old_password'
                ],
                'new_password_confirmation' => 'required|same:new_password',
            ], [
                // ✅ Safe fallback messages
                'new_password.regex' => __('app.password_validation_message', [], 'en') !== 'app.password_validation_message'
                    ? __('app.password_validation_message')
                    : 'Kata laluan mesti mengandungi sekurang-kurangnya satu huruf besar, satu huruf kecil, satu nombor dan satu aksara khas (!@#$%).',
                'new_password.different' => __('app.new_password_must_be_different', [], 'en') !== 'app.new_password_must_be_different'
                    ? __('app.new_password_must_be_different')
                    : 'Kata laluan baharu mestilah berbeza daripada kata laluan lama.',
                'new_password_confirmation.same' => 'Kata laluan pengesahan tidak sepadan dengan kata laluan baharu.'
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
                            __($remainingAttempts . ' attempts remaining.')
                        ]
                    ]
                ], 422);
            }
            
            $this->resetAdminFailedAttempts($uuid);
            
            $user->password = Hash::make($request->new_password);
            $user->save();
                
            return response()->json([
                'success' => true,
                'message' => __('app.password_updated_successfully')
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ✅ Always return JSON for validation issues
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // ✅ Handle unexpected exceptions gracefully
            \Log::error('Password change error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating password. Please try again later.',
            ], 500);
        }
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
        $search = request('search');
        
        $states = DB::table('state')
            ->select('idnegeri', 'negeri', 'negeri_code', 'status')
            ->when($search, function($query, $search) {
                return $query->where('negeri', 'like', "%{$search}%")
                            ->orWhere('negeri_code', 'like', "%{$search}%");
            })
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
        $search = request('search');

        $districts = DB::table('district')
            ->select('district.iddaerah', 'district.idnegeri', 'district.daerah', 'district.daerah_code', 'district.stat', 'state.negeri')
            ->join('state', 'district.idnegeri', '=', 'state.idnegeri')
            ->when($search, function($query, $search) {
                return $query->where('district.daerah', 'like', "%{$search}%")
                            ->orWhere('district.daerah_code', 'like', "%{$search}%")
                            ->orWhere('state.negeri', 'like', "%{$search}%");
            })
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
            'daerah_code' => 'string|max:11|unique:district,daerah_code',
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
            'daerah_code' => 'string|max:11|unique:district,daerah_code,' . $id . ',iddaerah',
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
            $search = $request->get('search');

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
                ->when($search, function($query, $search) {
                    return $query->where('div.mukim', 'like', "%{$search}%")
                                ->orWhere('div.mukim_code', 'like', "%{$search}%")
                                ->orWhere('d.daerah', 'like', "%{$search}%");
                })
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
                'mukim_code' => 'required|string|max:255',
                'status' => 'required|in:0,1'
            ], [
                'daerah_id.required' => 'District is required',
                'daerah_id.exists' => 'Selected district does not exist',
                'mukim.required' => 'Division name is required',
                'mukim.max' => 'Division name cannot exceed 255 characters',
                'mukim_code.required' => 'Division code is required',
                'mukim_code.max' => 'Division code cannot exceed 255 characters',
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

            // Check for duplicate division name in the same district
            $nameExists = DB::table('division')
                ->where('daerah_id', $request->daerah_id)
                ->where('mukim', trim($request->mukim))
                ->where('idmukim', '!=', $id)
                ->exists();

            if ($nameExists) {
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


    public function thirdPartyRequest()
    {
        $requests = \App\Models\ReceiptRequest::with(['application.landDistrict', 'application.landDivision'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $district = DB::table('district')->where('stat', 1)
            ->where('idnegeri', 1)
            ->orderBy('daerah_code', 'asc')
            ->get();

        return view('finance.my-requests', compact('requests', 'district'));
    }


    public function requestUpdateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:receipt_requests,id',
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
            'receipt_file' => 'nullable|file|mimes:jpg,png,pdf|max:4096',
        ]);

        $receipt = ReceiptRequest::find($request->id);

        $receipt->status = $request->status;
        $receipt->admin_notes = $request->admin_notes;
        $receipt->admin_uuid = auth('admin')->user()->uuid ?? null;

        // FILE UPLOAD USING YOUR CUSTOM LOGIC
        if ($request->status === 'approved') {

            $fileKey = 'receipt_file';

            if ($request->hasFile($fileKey)) {

                $uploadPath = public_path('pdf'); 

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $file = $request->file($fileKey);

                // Keep original name
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileExtension = $file->getClientOriginalExtension();
                $newFileName = $fileName . '.' . $fileExtension;

                // Move file to folder
                $file->move($uploadPath, $newFileName);

                // Save path in database (exactly like your code)
                $receipt->receipt_file_path = 'pdf/' . $newFileName;
            }
            $receipt->approved_at = now();
        }

        // If rejected → remove file
        if ($request->status === 'rejected') {
            $receipt->receipt_file_path = null;
            $receipt->approved_at = null;
        }

        $receipt->save();

        $thirdPartyUser = \App\Models\ThirdPartyUser::find($receipt->third_party_id);

        if ($thirdPartyUser) {
            $thirdPartyUser->notify(new ReceiptStatusUpdated($receipt));
        }

        return back()->with('success', 'Permohonan Salinan Resit berjaya dikemaskini.');
    }





    
    } 




