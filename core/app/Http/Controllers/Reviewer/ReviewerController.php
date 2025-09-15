<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
use App\Models\Application;
use App\Models\ClientRegisterModel;
use DB;
use App\Models\ReportReview;


class ReviewerController extends Controller
{
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

    public function index(){
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
        $assignmentcount=DB::table('report_reviews')->count();
        
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
          
          
        return view('reviewer.home', compact( 'totalAgencyApplication', 
        'newapplication',
        'assignmentcount',
        'monthapplication', 
        'approvedapplication', 
        'passed',
        'rejected',
        'applicationsByDistrict',
        'districts'));
    }
    //  public function paymentReview(){
    //     return view('reviewer.payment-to-review');
    // }
    
    
    public function paymentReview()
    {
        $reports = DB::table('report_reviews')
            ->select(
                'report_reviews.id',
                'report_reviews.report_number',
                'report_reviews.report_data',
                'report_reviews.submitted_by',
                'report_reviews.assigned_to',
                'report_reviews.status',
                'report_reviews.reviewer_comments',
                'report_reviews.submitted_at',
                'report_reviews.reviewed_at',
                'report_reviews.created_at',
                'report_reviews.updated_at',
                'submitter.username as submitter_name',
                'reviewer.name as reviewer_name'
            )
            ->leftJoin('users as submitter', 'report_reviews.submitted_by', '=', 'submitter.uuid')
            ->leftJoin('users as reviewer', 'report_reviews.assigned_to', '=', 'reviewer.uuid')
            ->orderBy('report_reviews.created_at', 'desc')
            ->get();
    
        // Decode JSON data
        $reports = $reports->map(function ($report) {
            $report->report_data = json_decode($report->report_data, true);
            return $report;
        });
        
    
        $totalReports = $reports->count();
        $pendingCount = $reports->where('status', 'pending')->count();
    
        return view('reviewer.payment-to-review', compact('reports', 'totalReports', 'pendingCount'));
    }
    public function collectorStatement(){
        return view('reviewer.collector-statement-report-reviewer');
    }
    public function collectorReceiptReview(Request $request, $report_id)
    {
        // Fetch the specific report from the report_reviews table
        $report = DB::table('report_reviews')
            ->select(
                'report_reviews.id',
                'report_reviews.report_number',
                'report_reviews.report_data',
                'report_reviews.submitted_by',
                'report_reviews.assigned_to',
                'report_reviews.status',
                'report_reviews.reviewer_comments',
                'report_reviews.submitted_at',
                'report_reviews.reviewed_at',
                'report_reviews.created_at',
                'report_reviews.updated_at',
                'submitter.username as submitter_name',
                'reviewer.username as reviewer_name'
            )
            ->leftJoin('users as submitter', 'report_reviews.submitted_by', '=', 'submitter.uuid')
            ->leftJoin('users as reviewer', 'report_reviews.assigned_to', '=', 'reviewer.uuid')
            ->where('report_reviews.id', $report_id)
            ->first();
    
        // If no report is found, return a 404 error
        if (!$report) {
            abort(404, 'Report not found');
        }
    
        // Decode JSON report_data
        $report->report_data = json_decode($report->report_data, true);
    
        // Prepare data to pass to the view
        $data = [
            'report' => $report,
        ];
    
        // Return the view with the report data
        return view('reviewer.collectors-receipt-reviewer', $data);
    }
    
    
    public function checkbook_receipt_reviewer(){
        return view('reviewer.checkbook_receipt_reviewer');
    }
    public function cash_book_report_reviewer(){
        return view('reviewer.cash_book_report_reviewer');
    }
    public function dailyPaymentReceiptReportReviewer(){
        return view('reviewer.daily-payment-receipt-report-reviewer');
    }
    public function dailyReceiptReportTypeReviewer(){
        return view('reviewer.daily-receipt-report-type-reviewer');
    }
    
   public function rejectReport(Request $request, $report_id)
{
    try {
        $request->validate([
            'report_id' => 'required',
            'reason'    => 'required|string|max:1000', // ✅ validate reason
        ]);

        // Find the report in report_reviews
        $report = ReportReview::findOrFail($report_id);

        // Check if review record exists
        $reportReview = DB::table('report_reviews')
            ->where('id', $report_id)
            ->first();

        if ($reportReview) {
            // ✅ Update existing record with rejection reason
            DB::table('report_reviews')
                ->where('id', $report_id)
                ->update([
                    'status'            => 'rejected',
                    'reviewer_comments' => $request->reason, // ✅ save reason
                    'submitted_by'      => auth('admin')->id(),
                    'reviewed_at'       => now(),
                    'updated_at'        => now()
                ]);
        } else {
            // ✅ Insert new record with rejection reason
            DB::table('report_reviews')->insert([
                'id'                => $report_id,
                'status'            => 'rejected',
                'reviewer_comments' => $request->reason, // ✅ save reason
                'submitted_by'      => auth('admin')->id(),
                'reviewed_at'       => now(),
                'created_at'        => now(),
                'updated_at'        => now()
            ]);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Report has been rejected successfully with reason.',
            'report_id' => $report_id
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error: ' . implode(', ', $e->errors())
        ], 422);

    } catch (\Exception $e) {
        \Log::error('Report rejection failed: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Failed to reject report. Please try again.'
        ], 500);
    }
}


}



