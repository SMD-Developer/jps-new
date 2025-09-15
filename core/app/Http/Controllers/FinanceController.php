<?php namespace App\Http\Controllers;

use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\Models\Application;
use App\Notifications\PaymentApprovedNotification;
use App\Notifications\PaymentRejectedNotification;
use App\Models\ClientRegisterModel;
use App\Models\Client as ClientUser ;
use App\Models\Payment;
use App\Models\ReportReview;

class financeController extends Controller {
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
                $totalAgencyApplication = DB::table('applications')
                ->join('client_register', 'applications.user_id', '=', 'client_register.client_id')
                ->where('client_register.accountType', '=', 3)
                ->count();
                $monthapplication = DB::table('applications')
                    ->whereMonth('created_at', date('m'))
                    ->count(); 
                $approvedapplication = DB::table('applications')->where('status', 'approved')->count(); 
                $passed = DB::table('applications')->where('status', 'approved')->count();
                $rejected = DB::table('applications')->where('status', 'rejected')->count();
                $assignmentNotTaken = DB::table('report_reviews')->count();
                $generateCollectorReport = DB::table('report_reviews')->count();
                
                $applicationsByDistrict = DB::table('applications')
                    ->select('district', DB::raw('count(*) as total'))
                    ->groupBy('district')
                    ->get();
                 
                    $districtCounts = DB::table('applications')
                    ->select('district', DB::raw('count(*) as count'))
                    ->groupBy('district')
                    ->get();
                    
                // Get district names
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
                return view('finance.home-finance', compact( 'totalAgencyApplication', 
                'newapplication', 
                'monthapplication', 
                'approvedapplication', 
                'assignmentNotTaken',
                'passed',
                'rejected',
                'applicationsByDistrict',
                'generateCollectorReport',
                'districts'));
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
    
    public function collectors_receipt(){
        return view('finance.collectors_receipt');
    }

    public function approved_statement(){
       $reports = DB::table('report_approvals')
                ->select(
                    'report_approvals.id',
                    'report_approvals.report_number',
                    'report_approvals.report_data',
                    'report_approvals.submitted_by',
                    'report_approvals.assigned_to',
                    'report_approvals.status',
                    'report_approvals.approver_comments',
                    'report_approvals.submitted_at',
                    'report_approvals.approved_at',
                    'report_approvals.created_at',
                    'report_approvals.updated_at',
                    'submitter.username as submitter_name',
                    'approver.username as approver_name',
                    'report_reviews.submitted_by as original_submitter_id',
                    'report_reviews.submitted_at as original_submitted_at',
                    'original_submitter.username as original_submitter_name'
                )
                ->leftJoin('users as submitter', 'report_approvals.submitted_by', '=', 'submitter.uuid')
                ->leftJoin('users as approver', 'report_approvals.assigned_to', '=', 'approver.uuid')
                ->leftJoin('report_reviews', 'report_approvals.report_number', '=', 'report_reviews.report_number')
                ->leftJoin('users as original_submitter', 'report_reviews.submitted_by', '=', 'original_submitter.uuid')
                ->orderBy('report_approvals.approved_at', 'desc') // Order by approval date
                ->whereIn('report_approvals.status', ['pending', 'approved'])
                ->get();
        
            // Decode JSON data
            $reports= $reports->map(function ($approval) {
                $approval->report_data = json_decode($approval->report_data, true);
                return $approval;
            });
        
            $totalApprovals = $reports->count();
            $approvedCount = $reports->where('status', 'approved')->count();
        return view('finance.approved_statement', compact('reports', 'totalApprovals', 'approvedCount'));
    }
    
    
    
    public function viewReportDetails(Request $request, $report_id)
    {
        
        $report = DB::table('report_approvals')
            ->select(
                'report_approvals.id',
                'report_approvals.report_number',
                'report_approvals.report_data',
                'report_approvals.submitted_by',
                'report_approvals.status',
                'report_approvals.approver_comments',
                'report_approvals.submitted_at',
                'report_approvals.approved_at',
                'report_approvals.created_at',
                'report_approvals.updated_at',
                'submitter.username as submitter_name',
                'approver.username as approver_name',
                'report_reviews.submitted_by as original_submitter_id',
                'report_reviews.submitted_at as original_submitted_at',
                'original_submitter.username as original_submitter_name',
                'report_reviews.reviewed_at as original_reviewed_at'
            )
            ->leftJoin('users as submitter', 'report_approvals.submitted_by', '=', 'submitter.uuid')
             ->leftJoin('users as approver', 'report_approvals.assigned_to', '=', 'approver.uuid')
            ->leftJoin('report_reviews', 'report_approvals.report_number', '=', 'report_reviews.report_number')
            ->leftJoin('users as original_submitter', 'report_reviews.submitted_by', '=', 'original_submitter.uuid')
            ->where('report_approvals.id', $report_id)
            ->first();
    
        if (!$report) {
            abort(404, 'Report not found or not available for approval');
        }
    
        $report->report_data = json_decode($report->report_data, true);
    
        // Prepare data to pass to the view
        $data = [
            'report' => $report,
        ];
    
        // Return the view with the report data
        return view('finance.report_details', $data);
    }

    
     public function collectors_statement_report_finance(){
        return view('finance.collectors-statement-report');
    }
    public function collectors_statement_report_ispek(){
        return view('finance.collectors-statement-report-ispeck');
    }

       public function financePaymentLetter(Request $request, $application_id)
       {
    
            $application = Application::select(
                'applications.*',
                'state.negeri',
                'district.daerah',
                'division.mukim as land_mukim',
                'land_district.daerah as land_daerah'
            )
                ->leftJoin('state', 'applications.state', '=', 'state.idnegeri')
                ->leftJoin('district', 'applications.district', '=', 'district.iddaerah')
                ->leftJoin('division', 'applications.land_state', '=', 'division.idmukim')
                ->leftJoin('district as land_district', 'division.daerah_id', '=', 'land_district.iddaerah')
                ->where('applications.id', $application_id)
                ->firstOrFail();
                $canFinanceAdminApproveReject = auth('admin')->user()->hasPermission('payments_agency.approve_reject');
    
            return view('finance.finance-pay-letter', compact('application', 'canFinanceAdminApproveReject'));
      }
      
    

        
         public function approvePayment(Request $request, $application_id)
         {
            if (!auth('admin')->check() || auth('admin')->user()->role_id !== '9e032970-5f48-4d2b-b88e-abb9da79140f') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $application = Application::findOrFail($application_id);
            if ($application->payment_status !== 'in review') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only payments in review can be approved'
                ], 400);
            }
    
            try {
                $currentDate = \Carbon\Carbon::now();
                $year = $currentDate->format('y');
                $month = $currentDate->format('m');
                $day = $currentDate->format('d');
    
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

                  $transactionId = 'TXN-' . mt_rand(1000000000, 9999999999);
    
                // Update applications table
                $application->update([
                    'payment_status' => 'completed',
                    'transaction' => $transactionId,
                    'reciept_number' => $receiptNumber,
                    'deposit_date' => \Carbon\Carbon::now(),
                ]);
                
                
                $payment = Payment::where('application_id', $application->id)
                         ->where('payment_status', 'in_review')
                         ->firstOrFail();
    
                $payment->update([
                    'payment_date' => \Carbon\Carbon::now(),
                    'amount' => $application->final_amount,
                    'method' => 'EFT',
                    'payment_status' => 'completed',
                    'transaction_id' => $transactionId,
                    'receipt_number' => $receiptNumber,
                    'gateway_transaction_id' => $transactionId,
                    'payment_gateway' => 'Bank Transfer',
                ]);
    
                $client = ClientRegisterModel::where('client_id', $application->user_id)->first();
                if ($client) {
                    $user_client = ClientUser::where('uuid', $application->user_id)->first();
    
                    if ($user_client) {
                        $user_client->notify(new PaymentApprovedNotification($application));
    
                        \Log::info('Payment approval notification sent', [
                            'application_id' => $application->id,
                            'client_id' => $application->user_id,
                            'payment_id' => $payment->id
                        ]);
                    } else {
                        \Log::warning('No client user record found for notification', [
                            'application_id' => $application->id,
                            'user_id' => $application->user_id
                        ]);
                    }
                } else {
                    \Log::warning('No client found for application', [
                        'application_id' => $application->id,
                        'user_id' => $application->user_id
                    ]);
                }
    
                return response()->json([
                    'success' => true,
                    'message' => 'Payment approved successfully',
                    'receipt_number' => $receiptNumber,
                    'transaction_id' => $transactionId
                ]);
            } catch (\Exception $e) {
                \Log::error('Payment approval error: ' . $e->getMessage());
    
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to approve payment: ' . $e->getMessage()
                ], 500);
            }
        }
       
       
         public function rejectPayment(Request $request, $application_id)
        {
            if (!auth('admin')->check() || auth('admin')->user()->role_id !== '9e032970-5f48-4d2b-b88e-abb9da79140f') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
        
            $application = Application::findOrFail($application_id);
            if ($application->payment_status !== 'in review') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only payments in review can be rejected'
                ], 400);
            }
        
            try {
                $request->validate([
                    'reason' => 'required|string|max:500',
                ]);
        
                $application->payment_status = 'rejected';
                $application->payment_rejection_reason = $request->reason; 
                $application->save();
                
                
                $client = ClientRegisterModel::where('client_id', $application->user_id)->first();
                if ($client) {
                    $user_client = ClientUser::where('uuid', $application->user_id)->first();
                    
                    if ($user_client) {
                        $user_client->notify(new PaymentRejectedNotification($application));
                        
                        \Log::info('Payment reject notification sent', [
                            'application_id' => $application->id,
                            'client_id' => $application->user_id
                        ]);
                    } else {
                        \Log::warning('No client user record found for notification', [
                            'application_id' => $application->id,
                            'user_id' => $application->user_id
                        ]);
                    }
                } else {
                    \Log::warning('No client found for application', [
                        'application_id' => $application->id,
                        'user_id' => $application->user_id
                    ]);
                }
        
                return response()->json([
                    'success' => true,
                    'message' => 'Payment rejected successfully'
                ]);
            } catch (\Exception $e) {
                \Log::error('Payment rejection error: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to reject payment'
                ], 500);
            }
        }
  
    public function finance_receipt_original(){
        return view('finance.Finance-receipt-original');
    }
    public function viewReceipt(){
        return view('finance.view-receipt');
    }
    
    // public function financeApprove(){
    //     $canfinanceAdminViewDetails = auth('admin')->user()->hasPermission('applications.view-details');
    //     $applications = Application::with('client')
    //     ->orderBy('created_at', 'desc')
    //     ->get();
    //     return view('finance.finance-approve', compact('applications', 'canfinanceAdminViewDetails'));
    // }
    
    public function financeApprove(Request $request){
        $perPage = $request->input('per_page', 10);
        $canfinanceAdminViewDetails = auth('admin')->user()->hasPermission('applications.view-details');
        
        $query = Application::with('client');
        

        if ($request->has('district') && $request->district) {
            $query->where('land_district', $request->district);
        }
        
        if ($request->has('division') && $request->division) {
            $query->where('land_state', $request->division);
        }
        
        if ($request->has('lot') && $request->lot) {
            $query->where('land_lot', 'LIKE', '%' . $request->lot . '%');
        }
        
        $applications = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->except('page'));
        
        $district = DB::table('district')->where('stat', 1)->orderBy('daerah_code', 'asc')->get();
        
        return view('finance.finance-approve', compact(
            'applications',
            'district',
            'perPage',
            'canfinanceAdminViewDetails'
        ));
    }
    
    public function cash_book_report_finance(){
        return view('finance.cash_book_report_finance');
    }
      public function checkbook_receipt_finance(){
        return view('finance.checkbook_receipt_finance');
    }
    //   public function dailyPaymentReceiptReport(Request $request){
    //     $request->validate([
    //         'start_date' => 'required|date_format:Y-m-d',
    //         'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
    //         'print_type' => 'nullable|string',
    //     ]);

    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');
    //     $printType = $request->input('print_type');

    //     $query = DB::table('applications')
    //         ->join('client_register', 'applications.user_id', '=', 'client_register.client_id')
    //         ->join('district', 'applications.district', '=', 'district.iddaerah')
    //         ->join('state', 'applications.state', '=', 'state.idnegeri')
    //         ->join('account_types', 'client_register.accountType', '=', 'account_types.id')
    //         ->select(
    //             'applications.*',
    //             'client_register.userName as client_name',
    //             'district.daerah as district_name',
    //             'state.negeri as state_name',
    //             'account_types.name as account_type_name'
    //         );

    //     if ($startDate && $endDate) {
    //         try {
    //             $startDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTimeString();
    //             $endDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTimeString();
    //             $query->whereBetween('applications.created_at', [$startDateParsed, $endDateParsed]);
    //         } catch (\Exception $e) {
    //             \Log::error('Invalid date format: ' . $e->getMessage());
    //             return back()->withErrors(['date' => 'Invalid date format. Use YYYY-MM-DD.']);
    //         }
    //     }

    //     $applications = $query->get();
    //     $applicationCount = $applications->count();
    //     \Log::info('Applications Count: ' . $applications->count());
    //     \Log::info('Applications created_at: ' . json_encode($applications->pluck('created_at')->toArray()));
    //     if ($startDate && $endDate) {
    //         $outOfRange = $applications->filter(function ($app) use ($startDateParsed, $endDateParsed) {
    //             return \Carbon\Carbon::parse($app->created_at)->lt($startDateParsed) || \Carbon\Carbon::parse($app->created_at)->gt($endDateParsed);
    //         });
    //         if ($outOfRange->isNotEmpty()) {
    //             \Log::warning('Out-of-range records: ' . json_encode($outOfRange->toArray()));
    //         }
    //     }
        
    //     $currentDateTime = \Carbon\Carbon::now();
    //     $currentDate = $currentDateTime->format('d/m/Y');
    //     $currentTime = $currentDateTime->format('h:i:s A');

    //     return view('finance.daily-payment-receipt-report',[
    //         'applications' => $applications,
    //         'printType' => $printType,
    //         'startDate' => $startDate,
    //         'endDate' => $endDate,
    //         'currentDate' => $currentDate,
    //         'currentTime' => $currentTime,
    //         'applicationCount' => $applicationCount,
    //     ]
    //      );
    // }
    
    public function dailyPaymentReceiptReport(Request $request)
{
    $request->validate([
        'start_date' => 'required|date_format:Y-m-d',
        'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
        'print_type' => 'nullable|string',
    ]);
    
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $printType = $request->input('print_type');
    
    // Build the base query
    $query = DB::table('applications')
        ->join('client_register', 'applications.user_id', '=', 'client_register.client_id')
        ->join('district', 'applications.district', '=', 'district.iddaerah')
        ->join('state', 'applications.state', '=', 'state.idnegeri')
        ->join('account_types', 'client_register.accountType', '=', 'account_types.id')
        ->leftJoin('payments', 'applications.id', '=', 'payments.application_id') // Left join with payments table
        ->select(
            'applications.*',
            'client_register.userName as client_name',
            'district.daerah as district_name',
            'state.negeri as state_name',
            'account_types.name as account_type_name',
            'payments.uuid as payment_id',
            'payments.receipt_number as receipt_numbers',
            'payments.amount as payment_amount',
            'payments.payment_date',
            'payments.method as methods',
            'payments.created_at as payment_created_at'
            
        )
        ->where('payments.payment_status', 'completed');
    
    // Apply date filtering if dates are provided
    if ($startDate && $endDate) {
        try {
            // Use your application's timezone (adjust as needed)
            $timezone = config('app.timezone', 'UTC');
            
            // Create start and end datetime with proper timezone
            $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate, $timezone)
                ->startOfDay();
            $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate, $timezone)
                ->endOfDay();
            
            // Apply the date filter to both applications and payments
            $query->where(function($q) use ($startDateTime, $endDateTime) {
                $q->whereBetween('applications.created_at', [
                    $startDateTime->toDateTimeString(),
                    $endDateTime->toDateTimeString()
                ])->orWhereBetween('payments.payment_date', [
                    $startDateTime->toDateTimeString(),
                    $endDateTime->toDateTimeString()
                ]);
            });
            
        } catch (\Exception $e) {
            return back()->withErrors(['date' => 'Invalid date format. Use YYYY-MM-DD.']);
        }
    }
    
    $applications = $query->get();
    $applicationCount = $applications->count();
    
    // Calculate total payment amount
    $totalPaymentAmount = $applications->sum('payment_amount');
    
    
    // Additional debugging for date range issues
    if ($startDate && $endDate && $applications->isEmpty()) {
        // Check if there are any applications in the table at all
        $totalApplications = DB::table('applications')->count();
        
        // Check the actual date range of applications in the database
        $dateRange = DB::table('applications')
            ->selectRaw('MIN(created_at) as earliest, MAX(created_at) as latest')
            ->first();
    }
    

    if ($startDate && $endDate && $applications->isNotEmpty()) {
        $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
        $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();
        
        $outOfRange = $applications->filter(function ($app) use ($startDateTime, $endDateTime) {
            $createdAt = \Carbon\Carbon::parse($app->created_at);
            $paymentDate = $app->payment_date ? \Carbon\Carbon::parse($app->payment_date) : null;
            
            return ($createdAt->lt($startDateTime) || $createdAt->gt($endDateTime)) &&
                   (!$paymentDate || $paymentDate->lt($startDateTime) || $paymentDate->gt($endDateTime));
        });
        
        if ($outOfRange->isNotEmpty()) {
            \Log::warning('Out-of-range records found: ', $outOfRange->toArray());
        }
    }
    
    $currentDateTime = \Carbon\Carbon::now();
    $currentDate = $currentDateTime->format('d/m/Y');
    $currentTime = $currentDateTime->format('h:i:s A');
    
    return view('finance.daily-payment-receipt-report', [
        'applications' => $applications,
        'printType' => $printType,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'currentDate' => $currentDate,
        'currentTime' => $currentTime,
        'applicationCount' => $applicationCount,
        'totalPaymentAmount' => $totalPaymentAmount,
    ]);
}

    public function dailyReceiptReportTypeFinance(){
        return view('finance.daily-receipt-report-type-finance');
    }
    public function task_not_completed_finance(){
        return view('finance.task_not_completed_finance');
    }
    public function treasury_receipts()
    {
        return view('finance.treasuryReceipts');
    }
    public function treasury_receipt_show()
    {
        return view('finance.treasury_receipt_show');
    }

    public function reportListApplicationContributionDitch(Request $request)
    {
        $request->validate([
            'account_type_id' => 'nullable|integer',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'print_type' => 'nullable|string',
        ]);
    
        $accountTypeId = $request->input('account_type_id'); 
        $startDate = $request->input('start_date');       
        $endDate = $request->input('end_date');             
        $printType = $request->input('print_type');         
    
        $query = DB::table('applications')
            ->join('client_register', 'applications.user_id', '=', 'client_register.client_id')
            ->join('account_types', 'client_register.accountType', '=', 'account_types.id')
            ->select(
                'applications.*',
                'client_register.userName as client_name', 
                'account_types.name as account_type_name'
            );
    
        if ($accountTypeId && $accountTypeId != '') {
            $query->where('client_register.accountType', $accountTypeId);
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
    
        return view('finance.report-list-all-application-contribution-ditch', [
            'title' => __("app.report_list_application_ditch_contributions"),
            'applications' => $applications,
            'printType' => $printType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentDate' => $currentDate,
            'currentTime' => $currentTime
        ]);
    }
    
    public function reportListApplicationContributionDitchSearch()
    {
        $title = __("app.report_list_application_ditch_contribution");
        $accountTypes = DB::table('account_types')->get();
        return view('finance.report-list-all-application-contribution-ditch-search',[
            'title' => $title,
            'accountTypes' => $accountTypes
        ]);
    }
    
    public function reportCollectionContributionDistrictSearch()
    {
        $title = __("app.report_collection_contribution_ditch_by_district");
        $districts = DB::table('district')->get();
        return view('finance.report-collection-contribution-ditch-by-district-search',['title' => $title,
         'districts'=> $districts]);
    }
    
     public function reportCollectionContributionDistrict(Request $request)
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
        
        return view('finance.report-collection-contribution-ditch-by-district', [
            'title' => __("app.report_collection_contribution_ditch_by_district"),
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
    
    
    public function receiptVoidReportSearch()
    {
        $title = __("app.receipt_void_report");
        return view('finance.receipt-void-report-search',['title' => $title]);
    }
    
     public function receiptVoidReport(Request $request)
     {
        $title = __("app.receipt_void_report");
        
        // Initialize variables
        $voidedReceipts = collect(); 
        $startDate = null;
        $endDate = null;
        $printType = 'PDF';
        $filtered = false; 
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $request->validate([
                'start_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
                'print_type' => 'nullable|string|in:PDF,Excel,Word',
            ]);
            
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $printType = $request->input('print_type', 'PDF');
            $filtered = true; 
            
            try {
                $startDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
                $endDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();
                $voidedReceipts = DB::table('applications')
                    ->whereBetween('created_at', [$startDateParsed, $endDateParsed])
                    ->get();
                \Log::info('Filtered receipts count: ' . $voidedReceipts->count());
                
                // Handle different output formats
                if ($printType === 'Excel') {
                } elseif ($printType === 'Word') {
                } elseif ($printType === 'PDF') {
                }
                
            } catch (\Exception $e) {
                \Log::error('Date parsing error: ' . $e->getMessage());
                return back()->withErrors(['date' => 'Invalid date format']);
            }
        }
        
        $currentDateTime = \Carbon\Carbon::now();
        $currentDate = $currentDateTime->format('d/m/Y');
        $currentTime = $currentDateTime->format('h:i:s A');
        
        return view('finance.receipt-void-report', [
            'title' => $title,
            'voidedReceipts' => $voidedReceipts,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'printType' => $printType,
            'filtered' => $filtered ,
            'currentDate' => $currentDate,
            'currentTime' => $currentTime
        ]);
     }
     
     
    public function paymentSummaryReport()
    {
        $title = __("app.payment_summary");
        return view('finance.report-summary-search',['title' => $title]);
    }
    
    public function paymentSummaryReportDetails(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'print_type' => 'required|in:PDF,Excel,Word'
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $printType = $request->input('print_type');

        $payments = DB::table('payments')
            ->select(
                DB::raw('DATE(payment_date) as payment_date'),
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('payment_date', '>=', $startDate)
            ->where('payment_date', '<=', $endDate)
            ->groupBy(DB::raw('DATE(payment_date)'))
            ->orderBy('payment_date', 'desc')
            ->get();

        $totalAmount = $payments->sum('total_amount');
        $totalPayments = $payments->sum('transaction_count');

        $detailedPayments = DB::table('payments')
            ->where('payment_date', '>=', $startDate)
            ->where('payment_date', '<=', $endDate)
            ->get();

        $paymentsByStatus = $detailedPayments->groupBy('payment_status');
        $statusSummary = [];
        foreach ($paymentsByStatus as $status => $statusPayments) {
            $statusSummary[$status] = [
                'count' => $statusPayments->count(),
                'total_amount' => $statusPayments->sum('amount')
            ];
        }

        $paymentsByMethod = $detailedPayments->groupBy('method');
        $methodSummary = [];
        foreach ($paymentsByMethod as $method => $methodPayments) {
            $methodSummary[$method] = [
                'count' => $methodPayments->count(),
                'total_amount' => $methodPayments->sum('amount')
            ];
        }
        
        $currentDateTime = \Carbon\Carbon::now();
        $currentDate = $currentDateTime->format('d/m/Y');
        $currentTime = $currentDateTime->format('h:i:s A');

        $reportData = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'currentDate' => $currentDate,
            'currentTime' => $currentTime,
            'total_amount' => $totalAmount,
            'total_payments' => $totalPayments,
            'payments' => $payments, 
            'status_summary' => $statusSummary,
            'method_summary' => $methodSummary,
            'generated_at' => now()->format('Y-m-d H:i:s')
        ];

        // Return the view with the report data
        return view('finance.payment-report-sumary-details', [
            'reportData' => $reportData,
            'title' => 'Laporan Ringkasan Pembayaran'
        ]);
    }
    
    
    // public function paymentSummaryReportDetails(Request $request)
    // {
    //     $request->validate([
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date|after_or_equal:start_date',
    //         'print_type' => 'required|in:PDF,Excel,Word'
    //     ]);
        
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');
    //     $printType = $request->input('print_type');
        
    //     // Modified query to only get completed payments
    //     $payments = DB::table('payments')
    //         ->select(
    //             DB::raw('DATE(payment_date) as payment_date'),
    //             DB::raw('COUNT(*) as transaction_count'),
    //             DB::raw('SUM(amount) as total_amount')
    //         )
    //         ->where('payment_date', '>=', $startDate)
    //         ->where('payment_date', '<=', $endDate)
    //         ->where('payment_status', 'completed') 
    //         ->groupBy(DB::raw('DATE(payment_date)'))
    //         ->orderBy('payment_date', 'desc')
    //         ->get();
            
    //     $totalAmount = $payments->sum('total_amount');
    //     $totalPayments = $payments->sum('transaction_count');
        
    //     // Modified query to only get completed payments for detailed analysis
    //     $detailedPayments = DB::table('payments')
    //         ->where('payment_date', '>=', $startDate)
    //         ->where('payment_date', '<=', $endDate)
    //         ->where('payment_status', 'completed')
    //         ->get();
        
    //     // Since we're only getting completed payments, this will only have 'completed' status
    //     $paymentsByStatus = $detailedPayments->groupBy('payment_status');
    //     $statusSummary = [];
    //     foreach ($paymentsByStatus as $status => $statusPayments) {
    //         $statusSummary[$status] = [
    //             'count' => $statusPayments->count(),
    //             'total_amount' => $statusPayments->sum('amount')
    //         ];
    //     }
        
    //     $paymentsByMethod = $detailedPayments->groupBy('method');
    //     $methodSummary = [];
    //     foreach ($paymentsByMethod as $method => $methodPayments) {
    //         $methodSummary[$method] = [
    //             'count' => $methodPayments->count(),
    //             'total_amount' => $methodPayments->sum('amount')
    //         ];
    //     }
        
    //     $currentDateTime = \Carbon\Carbon::now();
    //     $currentDate = $currentDateTime->format('d/m/Y');
    //     $currentTime = $currentDateTime->format('h:i:s A');
        
    //     $reportData = [
    //         'start_date' => $startDate,
    //         'end_date' => $endDate,
    //         'currentDate' => $currentDate,
    //         'currentTime' => $currentTime,
    //         'total_amount' => $totalAmount,
    //         'total_payments' => $totalPayments,
    //         'payments' => $payments, 
    //         'status_summary' => $statusSummary,
    //         'method_summary' => $methodSummary,
    //         'generated_at' => now()->format('Y-m-d H:i:s')
    //     ];
        
    //     // Return the view with the report data
    //     return view('finance.payment-report-sumary-details', [
    //         'reportData' => $reportData,
    //         'title' => 'Laporan Ringkasan Pembayaran'
    //     ]);
    // }
     
     
    public function governmentAgencyApplication(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        
        $applications = Application::with(['state', 'landDistrict', 'landDivision', 'client'])
            ->whereHas('client', function ($query) {
                $query->where('accountType', 3);
            })
            ->paginate($perPage);
        
        return view('application.government-agency-application', compact('applications', 'perPage'));
    }
    
    
     public function claimContributionReportSearch()
    {
        $title = __("app.claim_contribution_report");
        return view('finance.claim-report-search',[
            'title' => $title,
        ]);
    }

    public function claimContributionReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'print_type' => 'nullable|string',
        ]);

        $startDate = $request->input('start_date');       
        $endDate = $request->input('end_date');             
        $printType = $request->input('print_type');         

        $query = DB::table('claim_contribution')
            ->leftJoin('client_register', 'claim_contribution.user_id', '=', 'client_register.client_id')
            ->leftJoin('account_types', 'client_register.accountType', '=', 'account_types.id')
            ->select(
                'claim_contribution.*',
                'account_types.name as account_type_name'
            );

        if ($startDate && $endDate) {
            try {
                $startDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate)
                    ->startOfDay()
                    ->toDateTimeString();
                $endDateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate)
                    ->endOfDay()
                    ->toDateTimeString();
                    
                $query->whereBetween('claim_contribution.created_at', [$startDateParsed, $endDateParsed]);
            } catch (\Exception $e) {
                \Log::error('Invalid date format: ' . $e->getMessage());
                return back()->withErrors(['date' => 'Invalid date format. Use YYYY-MM-DD.']);
            }
        }

        $contributions = $query->get();

        \Log::info('Contributions Count: ' . $contributions->count());
        \Log::info('Contributions Date Range: ' . $startDate . ' to ' . $endDate);

        $currentDateTime = \Carbon\Carbon::now();
        $currentDate = $currentDateTime->format('d/m/Y');
        $currentTime = $currentDateTime->format('h:i:s A');

        return view('finance.claim-contribution-report-details', [
            'title' => __("app.claim_contribution_report_details"),
            'contributions' => $contributions,
            'printType' => $printType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentDate' => $currentDate,
            'currentTime' => $currentTime
        ]);
    }
    
}

