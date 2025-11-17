<?php namespace App\Http\Controllers\ClientArea;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ClientRegisterModel;
use DB;
use App\Notifications\AdminNewApplicationNotification;
use App\Notifications\DepositReceiptSubmitted;
use Illuminate\Support\Facades\Notification;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
// use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\State;
use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\ThirdPartyPrint;
use App\Models\ClaimContribution;
use App\Notifications\AdminNewClaimNotification;

class HomeController extends Controller {
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
	 */
	public function index()
	{
	    $logged_user = auth()->guard('user')->user();
        $invoices = $logged_user->invoices->count();
        $estimates = $logged_user->estimates->count();
        $recentInvoices = $logged_user->invoices->take(10);
        $recentEstimates = $logged_user->estimates->take(10);
        $invoice_stats['unpaid']        = $logged_user->invoices->where('status', getStatus('status', 'unpaid'))->count();
        $invoice_stats['paid']          = $logged_user->invoices->where('status', getStatus('status', 'paid'))->count();
        $invoice_stats['partiallyPaid'] = $logged_user->invoices->where('status', getStatus('status', 'partially_paid'))->count();
        $invoice_stats['overdue']       = $logged_user->invoices->where('status', getStatus('status', 'overdue'))->count();
        $total_outstanding              = $this->invoice->totalClientUnpaidAmount($logged_user->uuid);
        $total_payments = 0;
        foreach ($logged_user->invoices as $invoice){
            foreach ($invoice->payments as $payment){
                $total_payments += currency_convert(getCurrencyId($invoice->currency),$payment->amount);
            }
        }
        $total_payments = defaultCurrency(true).format_amount($total_payments);
		return view('clientarea.home', compact('invoices','estimates','recentInvoices','recentEstimates', 'invoice_stats','total_payments','total_outstanding'));
	}
	public function application(Request $request)
    {
            $clientId = auth('user')->id(); 
            $client = DB::table('client_register')->where('client_id', $clientId)->first();
            $state = DB::table('state')->where('status', 1)->orderBy('negeri_code', 'asc')->get();
            $district = DB::table('district')
            ->where('stat', 1)
            ->where('idnegeri', 1)
            ->orderBy('daerah_code', 'asc')
            ->get();
            $division = DB::table('division')->where('status', 1)->orderBy('mukim_code', 'asc')->get();
            $accountTypes = DB::table('account_types')->get();
            $landMeasurement = DB::table('land_measurement_unit')->get();
            // dd($landMeasurement);
            return view('clientarea.application', compact('state', 'district', 'division', 'client','landMeasurement', 'accountTypes'));
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
    
    
    
    
    
    public function getDivisions($id)
    {
         $division=DB::table('division')->where('daerah_id',$id)->where('status',1)->orderBy('mukim_code','asc')->get();
        // Return districts as JSON
        return response()->json($division);
    }
		
	public function applicationSubmit(Request $request){
        $logged_user = auth()->guard('user')->user();

        try {
            // Base validation rules
            $rules = [
                "uploade_date" => "required",
                "applicant" => "required",
                "address" => "required",
                "postal_code" => 'required|numeric|digits_between:4,8',
                "phone" => "numeric|digits_between:10,15",
                "email" => "required|email",
                "city" => "required",
                "district" => "required",
                "land_district" => "required",
                "land_lot" => "required",
                "land_area" => "required",
                "land_unit" => "required",
                "state" => "required",
                "land_grant" => "required|mimes:pdf|max:15000",
                "project_name" => "required"
                // "permission_plan" => "required|mimes:pdf|max:15000",
                // "letter_of_support" => "required|mimes:pdf|max:15000",
            ];

            // Only require 'identities' if applicant_type is NOT 3
            if ($request->input('applicant_type') != '3') {
                $rules['identities'] = 'required';
            }

            // Validate the request
            $this->validate($request, $rules, [
                "uploade_date.required" => trans('app.uploade_date_required'),
                "applicant.required" => trans('app.applicant_required'),
                "identities.required" => trans('app.identities_required'),
                "address.required" => trans('app.address_required'),
                "postal_code.required" => trans('app.postal_code_required'),
                "postal_code.numeric" => trans('app.postal_code_numeric'),
                "postal_code.digits" => trans('app.postal_code_digits'),
                "phone.required" => trans('app.phone_required'),
                "phone.numeric" => trans('app.phone_numeric'),
                "phone.digits_between" => trans('app.phone_digits_between'),
                "email.required" => trans('app.email_required'),
                "email.email" => trans('app.email_valid'),
                "city.required" => trans('app.city_required'),
                "district.required" => trans('app.district_required'),
                "land_district.required" => trans('app.land_district_required'),
                "land_lot.required" => trans('app.land_lot_required'),
                "land_area.required" => trans('app.land_area_required'),
                "land_unit.required" => trans('app.land_unit_required'),
                "state.required" => trans('app.state_required'),
                "land_grant.required" => trans('app.land_grant_required'),
                "land_grant.mimes" => trans('app.land_grant_mimes'),
                "land_grant.max" => trans('app.land_grant_max'),
                "permission_plan.required" => trans('app.permission_plan_required'),
                "permission_plan.mimes" => trans('app.permission_plan_mimes'),
                "permission_plan.max" => trans('app.permission_plan_max'),
                "letter_of_support.required" => trans('app.letter_of_support_required'),
                "letter_of_support.mimes" => trans('app.letter_of_support_mimes'),
                "letter_of_support.max" => trans('app.letter_of_support_max'),
            ]);

            $client = ClientRegisterModel::where('client_id', $logged_user->uuid)->first();
            
            if (!$client) {
                throw new \Exception("No client record found for the logged-in user. Please register as a client first.");
            }

            $request['user_id'] = $client->client_id;
            $uploadedFiles = [];
            $uploadPath = public_path('pdf');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }
            if (!is_writable($uploadPath)) {
                throw new \Exception("Upload path is not writable: " . $uploadPath);
            }

            if ($request->hasFile('land_grant')) {
                $landGrant = $request->file('land_grant');
                $landGrantFileName = $landGrant->getClientOriginalName();
                $landGrant->move($uploadPath, $landGrantFileName);
                $uploadedFiles['land_grant'] = 'pdf/' . $landGrantFileName;
            }

            if ($request->hasFile('permission_plan')) {
                $permissionPlan = $request->file('permission_plan');
                $permissionPlanFileName = $permissionPlan->getClientOriginalName();
                $permissionPlan->move($uploadPath, $permissionPlanFileName);
                $uploadedFiles['permission_plan'] = 'pdf/' . $permissionPlanFileName;
            }

            if ($request->hasFile('letter_of_support')) {
                $letterOfSupport = $request->file('letter_of_support');
                $letterOfSupportFileName = $letterOfSupport->getClientOriginalName();
                $letterOfSupport->move($uploadPath, $letterOfSupportFileName);
                $uploadedFiles['letter_of_support'] = 'pdf/' . $letterOfSupportFileName;
            }

            $requestData = array_merge($request->except('_token'), $uploadedFiles, ['status' => 1]);

            $applicationId = DB::table('applications')->insertGetId($requestData);

            return response()->json([
                'success' => true,
                'message' => __('app.the_application_has_been_sent'),
                'application_id' => $applicationId
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function claimSubmit(Request $request)
    {
        $logged_user = auth()->guard('user')->user();

        try {
            $isReapply = $request->has('is_reapply') && $request->is_reapply == 1;
            $fileValidationRules = $isReapply ? 'nullable' : 'required';
            
            // Base validation rules
            $rules = [
                "uploade_date" => "required",
                "applicant" => "required",
                "address" => "required",
                "postal_code" => 'required|numeric|digits_between:4,8',
                "phone" => "required|numeric|digits_between:10,15",
                "email" => "required|email",
                "city" => "required",
                "district" => "required",
                "land_district" => "required",
                "land_lot" => "required",
                "land_area" => "required",
                "land_unit" => "required",
                "state" => "required",
                "land_grant" => "{$fileValidationRules}|mimes:pdf|max:15000",
                "new_receipt" => "{$fileValidationRules}|mimes:pdf|max:15000",
                "supporting_docs" => "nullable|mimes:pdf|max:15000",
                "claim_reason" => "nullable|string|max:1000",
                "payment_amount" => "required|numeric|min:0",
            ];

            // Only require 'identities' if account_types is NOT 3
            if ($request->input('account_types') != '3') {
                $rules['identities'] = 'required';
            }

            $this->validate($request, $rules, [
                "uploade_date.required" => trans('app.uploade_date_required'),
                "applicant.required" => trans('app.applicant_required'),
                "identities.required" => trans('app.identities_required'),
                "address.required" => trans('app.address_required'),
                "postal_code.required" => trans('app.postal_code_required'),
                "postal_code.numeric" => trans('app.postal_code_numeric'),
                "postal_code.digits_between" => trans('app.postal_code_digits'),
                "phone.required" => trans('app.phone_required'),
                "phone.numeric" => trans('app.phone_numeric'),
                "phone.digits_between" => trans('app.phone_digits_between'),
                "email.required" => trans('app.email_required'),
                "email.email" => trans('app.email_valid'),
                "city.required" => trans('app.city_required'),
                "district.required" => trans('app.district_required'),
                "land_district.required" => trans('app.land_district_required'),
                "land_lot.required" => trans('app.land_lot_required'),
                "land_area.required" => trans('app.land_area_required'),
                "land_unit.required" => trans('app.land_unit_required'),
                "state.required" => trans('app.state_required'),
                "land_grant.required" => trans('app.land_grant_required'),
                "land_grant.mimes" => trans('app.land_grant_mimes'),
                "land_grant.max" => trans('app.land_grant_max'),
                "new_receipt.required" => trans('Resit Bayaran Baru diperlukan'),
                "new_receipt.mimes" => trans('app.land_grant_mimes'),
                "new_receipt.max" => trans('app.land_grant_max'),
                "supporting_docs.mimes" => trans('app.land_grant_mimes'),
                "supporting_docs.max" => trans('app.land_grant_max'),
                "payment_amount.required" => trans('app.claim_amount_required'),
                "payment_amount.numeric" => trans('app.claim_amount_numeric'),
                "payment_amount.min" => trans('app.claim_amount_positive'),
            ]);

            $client = ClientRegisterModel::where('client_id', $logged_user->uuid)->first();
            
            if (!$client) {
                throw new \Exception("No client record found for the logged-in user. Please register as a client first.");
            }

            $request['user_id'] = $client->client_id;
            $uploadedFiles = [];
            $uploadPath = public_path('pdf');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }
            if (!is_writable($uploadPath)) {
                throw new \Exception("Upload path is not writable: " . $uploadPath);
            }

            // Handle file uploads
            $fileFields = ['land_grant', 'new_receipt', 'supporting_docs'];
            
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $fileName = time() . '_' . $field . '_' . $file->getClientOriginalName();
                    $file->move($uploadPath, $fileName);
                    $uploadedFiles[$field] = 'pdf/' . $fileName;
                }
            }

            // Handle claim_reason (Optional)
            if ($request->filled('claim_reason')) {
                $uploadedFiles['claim_reason'] = $request->claim_reason;
            }

            // Prepare data for insertion/update
            $requestData = array_merge(
                $request->except(['_token', 'is_reapply', 'original_claim_id']), 
                $uploadedFiles, 
                [
                    'updated_at' => now(),
                ]
            );

            // **KEY CHANGE: Update existing record for reapplication**
            if ($isReapply && $request->has('original_claim_id')) {
                $originalClaimId = $request->original_claim_id;
                
                // Verify the claim belongs to the current user
                $existingClaim = DB::table('claim_contribution')
                    ->where('id', $originalClaimId)
                    ->where('user_id', $client->client_id)
                    ->first();
                    
                if (!$existingClaim) {
                    throw new \Exception("Invalid claim for reapplication.");
                }
                
                // Update the existing record
                DB::table('claim_contribution')
                    ->where('id', $originalClaimId)
                    ->update(array_merge($requestData, [
                        'status' => 'pending', // Reset status to pending
                        'reapplication_count' => ($existingClaim->reapplication_count ?? 0) + 1,
                        'last_reapplied_at' => now(),
                    ]));
                    
                $applicationId = $originalClaimId;
                
                // Send notification for reapplication
                try {
                    $updatedClaim = DB::table('claim_contribution')->where('id', $applicationId)->first();
                    $admins = User::where('role_id', '9e032984-8ef0-4e00-b7b9-439679a4d1aa')->get();
                    
                    if ($admins->isNotEmpty()) {
                        foreach ($admins as $admin) {
                            // Check if notification already exists for this reapplication
                            $existingNotification = $admin->notifications()
                                ->where('type', 'App\Notifications\AdminNewClaimNotification')
                                ->where('data->claim_id', $applicationId)
                                ->where('data->is_reapplication', true)
                                ->first();
                            
                            if (!$existingNotification) {
                                $admin->notify(new AdminNewClaimNotification($updatedClaim, true));
                            }
                        }
                    }
                } catch (\Exception $notificationError) {
                }
                
            } else {
                // Create new record for new applications
                $requestData['status'] = 'pending';
                $requestData['created_at'] = now();
                
                $applicationId = DB::table('claim_contribution')->insertGetId($requestData);

                // Send notifications for new application
                try {
                    $claim = DB::table('claim_contribution')->where('id', $applicationId)->first();
                    $admins = User::where('role_id', '9e032984-8ef0-4e00-b7b9-439679a4d1aa')->get();
                    
                    if ($admins->isNotEmpty()) {
                        foreach ($admins as $admin) {
                            $existingNotification = $admin->notifications()
                                ->where('type', 'App\Notifications\AdminNewClaimNotification')
                                ->where('data->claim_id', $applicationId)
                                ->first();
                            
                            if (!$existingNotification) {
                                $admin->notify(new AdminNewClaimNotification($claim));
                            }
                        }
                    }
                } catch (\Exception $notificationError) {
                    Log::error('Error notifying admin staff about claim: ', [
                        'claim_id' => $applicationId,
                        'message' => $notificationError->getMessage()
                    ]);
                }
            }

            $message = $isReapply 
                ? __('Permohonan semula telah berjaya dihantar')
                : __('app.the_application_has_been_sent');
        
            return response()->json([
                'success' => true,
                'message' => $message,
                'application_id' => $applicationId,
                'is_reapply' => $isReapply
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
		
    
       public function applicationStatus(Request $request)
        {
            $clientId = auth('user')->id();
            $perPage = $request->input('per_page', 10);
            
            // Modified query to get latest payment
            $query = Application::with([
                'client', 
                'logs', 
                'payments',
                'landDistrict', 
                'landDivision'
            ])
            ->where('user_id', $clientId)
            ->orderBy('created_at', 'desc');
            
            $applications = $query->paginate($perPage)
                ->through(function ($application) {
                    if ($application->status == 'rejected') {
                        $rejectionLog = $application->logs
                            ->where('status_to', 'rejected')
                            ->sortByDesc('created_at')
                            ->first();
                        
                        $application->setAttribute('rejected_by', $rejectionLog ? $rejectionLog->user_type : null);
                        $application->setAttribute('rejection_date', $rejectionLog ? $rejectionLog->created_at : null);
                    }
                    return $application;
                })
                ->appends($request->except('page'));

                $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
            
            return view('clientarea.application.applicationStatus', compact('applications', 'perPage', 'district'));
        }
        
		
		public function user_payment_letter($id){
             $application = Application::select('applications.*', 
            'state.negeri', 
            'district.daerah', 
            'division.mukim as land_mukim',
            'land_district.daerah as land_daerah')  // Added this line
        ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
        ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
        ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
        ->leftJoin('district as land_district', 'division.daerah_id', '=', 'land_district.iddaerah')  // Added this join
        ->where('applications.id', $id)
        ->firstOrFail();
		    return view('clientarea.application.user_payment_letter', compact('application'));
		}
		
		public function updatePrintStatus(Request $request, $id)
        {
            $application = Application::findOrFail($id);
            $application->increment('print_status_count'); 
            return response()->json(['success' => true, 'print_status_count' => $application->print_status_count]);
        }
		
		
		public function userApplicationDetails($id){
           $application = DB::table('applications')->where('id', $id)->first();
            if (!$application) {
                abort(404, __('app.application_not_found'));
            }
        
            // Fetch the state name based on the state ID
            $state = DB::table('state')->where('idnegeri', $application->state)->value('negeri');
            
            // Fetch the district name based on the district ID
            $district = DB::table('district')->where('iddaerah', $application->district)->value('daerah');
            
            // Fetch the land district name 
            $landDistrict = DB::table('district')->where('iddaerah', $application->land_district)->value('daerah');
            
            // Fetch the division/mukim data based on the land_state (mukim ID)
            $division = DB::table('division')->where('idmukim', $application->land_state)->first();
            
            // Create a formatted mukim display string if division exists
            $mukimDisplay = $division ? ($division->mukim_code . ' - ' . $division->mukim) : '';
        
            return view('clientarea.application.userdetails', compact('application','state', 'district', 'landDistrict' ,'division', 'mukimDisplay'));
       }
		
        
        public function userReceipt($application_id)
        {
            $application = Application::with(['payment' => function($query) {
                    $query->where('payment_status', 'completed')
                        ->latest('created_at');
                }])
                ->select(
                    'applications.*', 
                    'state.negeri', 
                    'district.daerah',
                    'division.mukim as land_mukim'
                )
                ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
                ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
                ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
                ->where('applications.id', $application_id)
                ->firstOrFail();
                
            if (auth('user')->id() !== $application->user_id) {
                abort(403, 'Unauthorized access to this receipt.');
            }
            
            $completedPayment = $application->payment()
                ->where('payment_status', 'completed')
                ->latest('created_at')
                ->first();
            
            if ($completedPayment) {
                $application->payment_status = $completedPayment->payment_status;
                $application->payment_method = $completedPayment->method;
                $application->payment_amount = $completedPayment->amount;
                $application->transaction_id = $completedPayment->transaction_id;
                $application->receipt_number = $completedPayment->receipt_number;
                $application->payment_date = $completedPayment->created_at;
                $application->gateway_response = $completedPayment->gateway_response;
                
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

            return view('clientarea.application.user-receiptoriginal', compact('application'));
        }
        
    
    
        public function userReceiptCopy($application_id)
        {
            $application = Application::with(['payment' => function($query) {
                    // Get only original completed payment (exclude reprint payments)
                    $query->where('payment_status', 'completed')
                        ->where(function($q) {
                            $q->where('payment_type', '!=', 'reprint')
                            ->orWhereNull('payment_type');
                        })
                        ->oldest('created_at'); // Changed to oldest to get FIRST payment
                }])
                ->select(
                    'applications.*', 
                    'state.negeri', 
                    'district.daerah',
                    'division.mukim as land_mukim'
                )
                ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
                ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
                ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
                ->where('applications.id', $application_id)
                ->firstOrFail();
                
            if (auth('user')->id() !== $application->user_id) {
                abort(403, 'Unauthorized access to this receipt.');
            }
            
            // Get the original completed payment (not reprint)
            $completedPayment = $application->payment()
                ->where('payment_status', 'completed')
                ->where(function($q) {
                    $q->where('payment_type', '!=', 'reprint')
                    ->orWhereNull('payment_type');
                })
                ->oldest('created_at') // Get the FIRST original payment
                ->first();
            
            if ($completedPayment) {
                $application->payment_status = $completedPayment->payment_status;
                $application->payment_method = $completedPayment->method;
                $application->payment_amount = $completedPayment->amount;
                $application->transaction_id = $completedPayment->transaction_id;
                $application->receipt_number = $completedPayment->receipt_number;
                $application->payment_date = $completedPayment->created_at;
                $application->gateway_response = $completedPayment->gateway_response;
                
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

            return view('clientarea.application.user-receiptcopy', compact('application'));
        }



        public function userRprintPaymentReceipt($application_id)
        {
            $application = Application::with(['payment' => function($query) {
                    $query->where('payment_status', 'completed')
                        ->where('payment_type', 'reprint') 
                        ->latest('created_at');
                }])
                ->select(
                    'applications.*', 
                    'state.negeri', 
                    'district.daerah',
                    'division.mukim as land_mukim'
                )
                ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
                ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
                ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
                ->where('applications.id', $application_id)
                ->firstOrFail();
                
            if (auth('user')->id() !== $application->user_id) {
                abort(403, 'Unauthorized access to this receipt.');
            }
            
            // Get the reprint payment specifically
            $reprintPayment = $application->payment()
                ->where('payment_status', 'completed')
                ->where('payment_type', 'reprint') // Filter for reprint payment only
                ->latest('created_at')
                ->first();
            
            if (!$reprintPayment) {
                return redirect()->back()->with('error', 'Reprint payment receipt not found.');
            }
            
            // Assign reprint payment data to application object
            $application->payment_status = $reprintPayment->payment_status;
            $application->payment_method = $reprintPayment->method;
            $application->payment_amount = $reprintPayment->amount; // This will be RM 10
            $application->transaction_id = $reprintPayment->transaction_id;
            $application->receipt_number = $reprintPayment->receipt_number;
            $application->payment_date = $reprintPayment->created_at;
            $application->gateway_response = $reprintPayment->gateway_response;
            $application->payment_type = $reprintPayment->payment_type; // Add payment type
            
            if ($reprintPayment->gateway_response) {
                $gatewayResponse = is_array($reprintPayment->gateway_response) 
                    ? $reprintPayment->gateway_response 
                    : json_decode($reprintPayment->gateway_response, true);
                    
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

            // Use a different view for reprint payment receipt
            return view('clientarea.application.user-reprint-payment-receipt', compact('application'));
        }
    
    
        public function contribution_history(Request $request){
            $clientId = auth('user')->id();
            $perPage = $request->input('per_page', 10);
            
            $applications = Application::with('client')
                ->where('user_id', $clientId)
                ->where('status', 'approved')
                ->whereHas('payment', function($query) {
                    $query->where('payment_status', 'completed');
                })
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
            
            return view('clientarea.application.contribution_history', compact('applications', 'perPage'));
        }
        
        public function contributionClaim(){
            $clientId = auth('user')->id(); 
            $client = DB::table('client_register')->where('client_id', $clientId)->first();
            $state = DB::table('state')->where('status', 1)->orderBy('negeri_code', 'asc')->get();
            $district = DB::table('district')
            ->where('idnegeri', 1)
            ->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
            $division = DB::table('division')->where('status', 1)->orderBy('mukim_code', 'asc')->get();
            $landMeasurement = DB::table('land_measurement_unit')->get();
            $accountTypes = DB::table('account_types')->get();
            return view('clientarea.application.contribution_claims', compact('state', 'district', 'division', 'client', 'accountTypes','landMeasurement'));
        }

        public function claimReapply($id)
        {
            $clientId = auth('user')->id();
            
            $claim = DB::table('claim_contribution') 
                ->where('id', $id)
                ->where('user_id', $clientId) 
                ->first();
            if (!$claim) {
                return redirect()->back()->with('error', 'Application not found.');
            }
            
            if ($claim->status != 'rejected') {
                return redirect()->back()->with('error', 'Only rejected applications can be reapplied.');
            }
            
            $client = DB::table('client_register')->where('client_id', $clientId)->first();
            $state = DB::table('state')->where('status', 1)->orderBy('negeri_code', 'asc')->get();
            $district = DB::table('district')
                ->where('idnegeri', 1)
                ->where('stat', 1)
                ->orderBy('daerah_code', 'asc')
                ->get();
            $division = DB::table('division')->where('status', 1)->orderBy('mukim_code', 'asc')->get();
            $landMeasurement = DB::table('land_measurement_unit')->get();
            $accountTypes = DB::table('account_types')->get();
            return view('clientarea.application.contribution_claims', compact(
                'state', 
                'district', 
                'division', 
                'client', 
                'accountTypes',
                'landMeasurement',
                'claim' 
            ));
        }
        
        
        
        public function userClaimList(Request $request)
        {
            $clientId = auth('user')->id(); 
            
            $perPage = $request->input('per_page', 10);         
            
            $query = ClaimContribution::with(['state', 'landDistrict', 'landDivision', 'client'])
                        ->where('user_id', $clientId); 
            
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
            
            $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get(); 
            
            return view('clientarea.claim.claim-list', compact(
                'list',              
                'district',              
                'perPage'              
            ));
        }
         
         
         
        public function faq(){
            return view('clientarea.faq');
        }
        
        
        public function contactSupport(){
            return view('clientarea.contactSupport');
        }
        
        
        public function updateprofile(){
            return view('clientarea.profile.updateprofile');
        }
        
        
        public function newpayment(){
            return view('clientarea.payment_methods.new-payment');
        }

        public function paymentrecords(){
            return view('clientarea.payment_methods.payment-record');
        }
        
    public function helpdesk(){
        return view('clientarea.helpdesk');
}
    public function usermanual(){
        return view('clientarea.user-manual');
}
// Government-agency start
    public function government_letter(){
		    return view('clientarea.application.gov-pay-letter');
		}

    public function userNotification(){
            $title = __("app.all_notification");
		    return view('clientarea.notification.user-notification',compact('title'));
	}   
        
        
        public function notifyAdminNewApplication(Request $request)
        {
            try {
                $request->validate([
                    'application_id' => 'required|exists:applications,id'
                ]);
    
                $application = Application::findOrFail($request->application_id);
    
                $admins = User::where('role_id', '9e032984-8ef0-4e00-b7b9-439679a4d1aa')->get();
    
                if ($admins->isEmpty()) {
                    Log::warning('No admin staff found to notify', ['application_id' => $application->id]);
                    return response()->json(['success' => false, 'message' => 'No admin staff found'], 404);
                }
    
                Notification::send($admins, new AdminNewApplicationNotification($application));
    
                Log::info('Admin staff notified of new application', [
                    'application_id' => $application->id,
                    'admin_count' => $admins->count()
                ]);
    
                return response()->json(['success' => true, 'message' => 'Admin staff notified successfully']);
            } catch (\Exception $e) {
                Log::error('Error notifying admin staff: ', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json(['success' => false, 'message' => 'Server error occurred: ' . $e->getMessage()], 500);
            }
        }


        public function markAsReads($id)
        {
                try {
                    $user = auth::guard('user')->user();

                    if (!$user) {
                        \Log::info('No user found in guard user');
                        return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
                    }

                    $notification = $user->notifications()->where('id', $id)->first();

                    if (!$notification) {
                        \Log::info('Notification not found: ' . $id);
                        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
                    }

                    $notification->markAsRead();

                    return response()->json(['success' => true, 'message' => 'Notification marked as read']);
                } catch (\Exception $e) {
                    \Log::error('Error in markAsReads(): ' . $e->getMessage());
                    return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
                }
        }

        
        public function markAllAsRead()
        {
            auth('user')->user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        }


        public function getCount()
        {
            $count = auth('user')->user()->unreadNotifications->count();
            return response()->json(['count' => $count]);
        }
    
        public function getNotifications()
        {
            $notifications = auth('user')->user()
                ->notifications()
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
            return response()->json(['notifications' => $notifications]);
        }
        
        public function showApprovalLetter($application_id)
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
            return view('clientarea.application.user_approval_letter', compact('application'));
        }
    
    
        public function uploadDepositReceipt($application_id)
        {
            // You can add validation if needed
            $application = Application::findOrFail($application_id);
            
            return view('clientarea.uploadDepositReceipt', [
                'application' => $application
            ]);
        }
        
    
    public function submitDeposit(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'application_id' => 'required|exists:applications,id',
                'deposit_date' => 'required|date|before_or_equal:today',
                'transaction' => [
                    'required',
                    'regex:/^[A-Za-z0-9\-]+$/',
                    'max:50',
                    'unique:applications,transaction,' . $request->application_id,
                ],
                'voucher_number' => [  
                    'required',
                    'regex:/^[A-Za-z0-9\-]+$/',
                    'max:50',
                ],
                'receipt' => 'required|file|mimes:pdf|max:15360',
                'note' => 'nullable|string|max:500'
            ],
            [
                'deposit_date.required' => 'Medan ini wajib diisi.',  
                'deposit_date.before_or_equal' => 'Tarikh bayaran tidak boleh melebihi hari ini.',
                'transaction.required' => 'Medan ini wajib diisi.',
                'transaction.unique' => 'Nombor transaksi ini telah digunakan.',
                'voucher_number.required' => 'Medan ini wajib diisi.', 
                'voucher_number.unique' => 'Nombor baucar ini telah digunakan.', 
                'receipt.required' => 'Fail wajib dimuatnaik.',
                'receipt.mimes' => 'Fail mestilah dalam format PDF, JPG, JPEG, atau PNG.',
                'receipt.max' => 'Saiz fail tidak boleh melebihi 2MB.',
                'transaction.regex' => 'Nombor transaksi hanya boleh mengandungi huruf, nombor dan sempang.',
            ]
        );

          if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
    
        try {
            // Set up upload path for receipts (following your pattern)
            $uploadPath = public_path('receipts');
    
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }
            if (!is_writable($uploadPath)) {
                throw new \Exception("Upload path is not writable: " . $uploadPath);
            }
    
            // Handle file upload (following your exact pattern)
            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $receipt = $request->file('receipt');
                $receiptFileName = $receipt->getClientOriginalName();
                $receipt->move($uploadPath, $receiptFileName);
                $receiptPath = 'receipts/' . $receiptFileName;
            }
    
            $application = Application::find($request->application_id);
            $application->update([
                'deposit_date' => $validated['deposit_date'],
                'transaction' => $validated['transaction'],
                'receipt_path' => $receiptPath,
                'note' => $validated['note'],
                'payment_status' => 'in review'
            ]);
            
            Payment::create([
                'application_id' => $application->id,
                'transaction_id' => $validated['transaction'],
                'payment_date' => $validated['deposit_date'],
                'receipt_path' => $receiptPath,
                'payment_status' => 'in_review',
                'voucher_number' => $validated['voucher_number'],
                'method' => 'EFT',
                'amount' => $application->final_amount ?? null, 
            ]);
            
            $financeAdmin = User::where('role_id', '9e032970-5f48-4d2b-b88e-abb9da79140f')->first();
            
            if (!$financeAdmin) {
                \Log::warning('No finance admin with role_id: 9e032970-5f48-4d2b-b88e-abb9da79140f');
                return response()->json(['success' => false, 'message' => 'No approver found'], 404);
            }
    
            $financeAdmin->notify(new DepositReceiptSubmitted($application));
    
            return response()->json([
                'success' => true,
                'message' => 'Butiran pembayaran berjaya dihantar!',
                'redirect' => url()->previous()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Submit deposit error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit payment details. Please try again.'
            ], 500);
        }
    }



    public function resubmitApplication($id)
    {
        try {
            $application = Application::findOrFail($id);
            // if ($application->user_id !== auth()->id()) {
            //     return redirect()->back()->with('error', trans('app.unauthorized_access'));
            // }

            // if ($application->status !== 'rejected') {
            //     return redirect()->back()->with('error', trans('app.application_not_rejected'));
            // }
            
            $state=DB::table('state')->where('status',1)->orderBy('negeri_code','asc')->get();
            $district=DB::table('district')->where('stat',1)->orderBy('daerah_code','asc')->get();
	        $division=DB::table('division')->where('status',1)->orderBy('mukim_code','asc')->get();
            $landCategories = DB::table('land_category')->get();
            $landMeasurement = DB::table('land_measurement_unit')->get();
            $accountTypes = DB::table('account_types')->get();
            return view('clientarea.resubmit-application', compact('application', 'state', 'district','division', 'landCategories','landMeasurement', 'accountTypes'));
            
        } catch (\Exception $e) {
            \Log::error('Error accessing resubmit application: ' . $e->getMessage());
            return redirect()->back()->with('error', trans('app.something_went_wrong'));
        }
    }
    
    
    
    public function updateResubmitApplication(Request $request, $id)
    {
        try {
            $application = DB::table('applications')->where('id', $id)->first();
            $currentUser = auth('user')->user();

            if (!$application) {
                return redirect()->back()->with('error', __('app.application_not_found'));
            }

            // Get the applicant type from the application
            $applicantType = $application->applicant_type;

            // Define base validation rules
            $validationRules = [
                "uploade_date" => "required",
                "applicant" => "required",
                "address" => "required",
                "phone" => "required|numeric|digits_between:8,12",
                "email" => "required|email",
                "state" => "required",
                "city" => "required",
                "district" => "required",
                "project_name" => "required",
                "land_lot" => "required",
                "land_area" => "required",
                "land_district" => "required",
                "land_state" => "required",
            ];

            // Only add identities validation if applicant_type is NOT 3 (Agency)
            if ($applicantType != 3) {
                $validationRules["identities"] = "required";
            }

            // Custom validation messages
            $customMessages = [
                'land_grant.max' => 'The land grant file size cannot exceed 15MB.',
                'permission_plan.max' => 'The permission plan file size cannot exceed 15MB.',
                'letter_of_support.max' => 'The letter of support file size cannot exceed 15MB.',
                'land_grant.mimes' => 'The land grant file must be a PDF.',
                'permission_plan.mimes' => 'The permission plan file must be a PDF.',
                'letter_of_support.mimes' => 'The letter of support file must be a PDF.',
                'identities.required' => 'The identification card number is required.',
            ];

            // Check if files are uploaded and add validation rules
            $fileKeys = ['land_grant', 'permission_plan', 'letter_of_support'];
            foreach ($fileKeys as $key) {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    
                    // Check file size before validation (15MB = 15360KB)
                    if ($file->getSize() > 15728640) { // 15MB in bytes
                        return response()->json([
                            'success' => false,
                            'message' => "The {$key} file size (" . $this->formatFileSize($file->getSize()) . ") exceeds the maximum limit of 15MB.",
                            'errors' => [$key => ["File size exceeds 15MB limit"]]
                        ], 422);
                    }
                    
                    // Add validation rules for the uploaded file
                    $validationRules[$key] = 'file|mimes:pdf|max:15360'; // 15MB in KB
                }
            }

            // Validate the request
            $validator = \Validator::make($request->all(), $validationRules, $customMessages);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed. Please check your inputs.'
                ], 422);
            }

            // Handle file uploads with additional size checking
            $uploadedFiles = [];
            $uploadPath = public_path('pdf');
            
            // Ensure upload directory exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
        
            foreach ($fileKeys as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    
                    // Double-check file size (extra security)
                    if ($file->getSize() > 15728640) { // 15MB in bytes
                        return response()->json([
                            'success' => false,
                            'message' => "File {$file->getClientOriginalName()} exceeds the 15MB size limit.",
                            'errors' => [$fileKey => ["File size exceeds 15MB limit"]]
                        ], 422);
                    }
                    
                    // Check if file is actually a PDF by checking MIME type
                    if ($file->getMimeType() !== 'application/pdf') {
                        return response()->json([
                            'success' => false,
                            'message' => "File {$file->getClientOriginalName()} is not a valid PDF file.",
                            'errors' => [$fileKey => ["File must be a PDF"]]
                        ], 422);
                    }
                    
                    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); 
                    $fileExtension = $file->getClientOriginalExtension(); 
                    $newFileName = $fileName . '_' . time() . '.' . $fileExtension; // Add timestamp to avoid conflicts
            
                    try {
                        $file->move($uploadPath, $newFileName);
                        $uploadedFiles[$fileKey] = 'pdf/' . $newFileName;
                    } catch (\Exception $e) {
                        \Log::error("File upload failed for {$fileKey}: " . $e->getMessage());
                        return response()->json([
                            'success' => false,
                            'message' => "Failed to upload {$fileKey}. Please try again.",
                            'errors' => [$fileKey => ["Upload failed"]]
                        ], 500);
                    }
                }
            }

            // Prepare update data
            $updateData = [
                "uploade_date" => $request->input('uploade_date', $application->uploade_date),
                "applicant" => $request->input('applicant', $application->applicant),
                "address" => $request->input('address', $application->address),
                "postal_code" => $request->input('postal_code', $application->postal_code),
                "phone" => $request->input('phone', $application->phone),
                "email" => $request->input('email', $application->email),
                "city" => $request->input('city', $application->city),
                "district" => $request->input('district', $application->district),
                "project_name" => $request->input('project_name', $application->project_name),
                "land_district" => $request->input('land_district', $application->land_district),
                "land_state" => $request->input('land_state', $application->land_state),
                "land_lot" => $request->input('land_lot', $application->land_lot),
                "land_area" => $request->input('land_area', $application->land_area),
                "state" => $request->input('state', $application->state),
                "status" => 'pending',
                "rejection_reason" => null,
                "application_type" => 'reapply',
                "updated_at" => now()
            ];

            // Handle identities field conditionally
            if ($applicantType != 3) {
                // For non-Agency types, update identities if provided
                $updateData["identities"] = $request->input('identities', $application->identities);
            } else {
                // For Agency (type 3), keep existing identities or set to null if empty
                $updateData["identities"] = $request->input('identities') ?: null;
            }

            // Handle file removal requests
            $removeFields = ['remove_land_grant', 'remove_permission_plan', 'remove_letter_of_support'];
            foreach ($removeFields as $removeField) {
                if ($request->input($removeField) == '1') {
                    $fileField = str_replace('remove_', '', $removeField);
                    $updateData[$fileField] = null;
                    
                    // Optionally delete the old file from disk
                    $oldFilePath = public_path($application->{$fileField});
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
            }

            // Merge uploaded files data
            if (!empty($uploadedFiles)) {
                $updateData = array_merge($updateData, $uploadedFiles);
            }

            \Log::info("Update data:", $updateData);
        
            DB::beginTransaction();
            
            try {
                DB::table('applications')->where('id', $id)->update($updateData);
                
                // Log the resubmission
                DB::table('application_logs')->insert([
                    'application_id' => $id,
                    'user_type' => 'applicant', 
                    'action' => 'reapply',
                    'status_from' => $application->status, 
                    'status_to' => 'pending',
                    'remarks' => 'Application resubmitted by user',
                    'user_id' => $currentUser->id ?? null,
                    'additional_data' => json_encode([
                        'performed_by' => $currentUser->name ?? 'User',
                        'reapplication_date' => now()->format('Y-m-d H:i:s'),
                        'uploaded_files' => array_keys($uploadedFiles),
                        'applicant_type' => $applicantType
                    ]),
                    'action_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                // Commit the transaction
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => __('app.application_has_been_updated')
                ]);
                
            } catch (\Exception $e) {
                DB::rollback();
                \Log::error("Database transaction failed: " . $e->getMessage());
                throw $e;
            }
            
        } catch (\Exception $e) {
            \Log::error("Application update failed: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 500);
        }
    }

    /**
     * Format file size in human readable format
     */
    private function formatFileSize($bytes)
    {
        if ($bytes === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }
 
 
    public function success()
    {
        return view('clientarea.payment_success');
    }
    
    
    public function searchApplications(Request $request)
    {
        $query = Application::query();
    
        $query->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
              ->leftJoin('district', 'applications.land_district', '=', 'district.iddaerah')
              ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
              ->select('applications.*', 
                       'state.negeri as state_name',
                       'district.daerah as district_name',
                       'division.mukim as division_name');
        
        if ($request->filled('state')) {
            $query->where('applications.state', $request->state);
        }
        
        if ($request->filled('district')) {
            $query->where('applications.land_district', $request->district);
        }
        
        if ($request->filled('division')) {
            $query->where('applications.land_state', $request->division);
        }
        
        if ($request->filled('applicant_name')) {
            $query->where('applications.applicant', 'LIKE', '%' . $request->applicant_name . '%');
        }
        
        if ($request->filled('lot_number')) {
            $query->where('applications.land_lot', 'LIKE', '%' . $request->lot_number . '%');
        }
        
         // Add reference number search filter
        if ($request->filled('reference_no')) {
            $query->where('applications.refference_no', 'LIKE', '%' . $request->reference_no . '%');
        }
    
        
        // Get paginated results
        $applications = $query->orderBy('applications.created_at', 'desc')
                             ->paginate(10);
        
        $states = State::all();
        $districts = collect();
        $divisions = collect();
        
        if ($request->filled('state')) {
            $districts = District::where('idnegeri', $request->state)->get();
        }
        
        if ($request->filled('district')) {
            $divisions = Division::where('daerah_id', $request->district)->get();
        }
        
        $filters = $request->all();
        
        return view('clientarea.application.search-results', compact(
            'applications', 
            'states', 
            'districts', 
            'divisions',
            'filters'
        ));

    }
    
    public function searchResult(Request $request)
    {
        try {
            // Initialize the query
            $query = Application::query();

            // Join related tables
            $query->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
                  ->leftJoin('district', 'applications.land_district', '=', 'district.iddaerah')
                  ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
                  ->select(
                      'applications.*',
                      'state.negeri as state_name',
                      'district.daerah as district_name',
                      'division.mukim as division_name'
                  );

            $query->with('payment')
              ->whereHas('payment', function($q) {
                  $q->where('payment_status', 'completed');
            });

            // Retrieve filters from session or query parameters
            $filters = $request->session()->get('search_filters', $request->query());

            // Apply filters based on session or query parameters
            if (!empty($filters['state'])) {
                $query->where('applications.state', $filters['state']);
            }

            if (!empty($filters['district'])) {
                $query->where('applications.land_district', $filters['district']);
            }

            if (!empty($filters['division'])) {
                $query->where('applications.land_state', $filters['division']);
            }

            if (!empty($filters['applicant_name'])) {
                $query->where('applications.applicant', 'LIKE', '%' . $filters['applicant_name'] . '%');
            }

            if (!empty($filters['lot_number'])) {
                $query->where('applications.land_lot', 'LIKE', '%' . $filters['lot_number'] . '%');
            }
            
            if ($request->filled('reference_no')) {
                $query->where('applications.refference_no', 'LIKE', '%' . $request->reference_no . '%');
            }

            // Get paginated results
            $applications = $query->orderBy('applications.created_at', 'desc')->paginate(10);

            // Fetch states, districts, and divisions
            $states = State::all();
            $districts = collect();
            $divisions = collect();

            if (!empty($filters['state'])) {
                $districts = District::where('idnegeri', $filters['state'])->get();
            }

            if (!empty($filters['district'])) {
                $divisions = Division::where('daerah_id', $filters['district'])->get();
            }

            // Append query parameters to pagination links
            $applications->appends($filters);

            return view('clientarea.application.search-results', compact(
                'applications',
                'states',
                'districts',
                'divisions',
                'filters'
            ));
        } catch (\Exception $e) {
            Log::error('Error in searchResult: ' . $e->getMessage());
            return redirect()->route('applications.search')->with('error', 'No search criteria found. Please perform a new search.');
        }
    }


   
 
}
