<?php

namespace App\Http\Controllers;

use App\Invoicer\Repositories\Contracts\InvoiceInterface as Invoice;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ClientInterface as Client;
use App\Invoicer\Repositories\Contracts\EstimateInterface as Estimate;
use App\Invoicer\Repositories\Contracts\PaymentInterface as Payment;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
use Illuminate\View\View;
use App\Models\Application;
use App\Models\ClientRegisterModel;
use DB;
use App\Models\ReportApproval;

use Illuminate\Http\Request;

class ApproverController extends Controller
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


     public function approverHome()
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
        
        $applicationsByDistrict = DB::table('applications')
            ->select('land_district', DB::raw('count(*) as total'))
            ->groupBy('land_district')
            ->get();
         
        $districtCounts = DB::table('applications')
            ->select('land_district', DB::raw('count(*) as count'))
            ->groupBy('land_district')
            ->get();
            
        // Get district names
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
        return view('approver.home', compact( 'totalAgencyApplication', 
        'newapplication', 
        'monthapplication', 
        'approvedapplication', 
        'passed',
        'rejected',
        'applicationsByDistrict',
        'districts'));
    }
    
    public function approve(){
        $canFinanceApproverApplicationDetails = auth('admin')->user()->hasPermission('applications.view-details');
        $applications = Application::with('client')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('approver.approve', compact('applications', 'canFinanceApproverApplicationDetails'));
    }
    
     public function approved_statement_approver()
        {
            $approvals = DB::table('report_approvals')
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
                    'approver.username as approver_name'
                )
                ->leftJoin('users as submitter', 'report_approvals.submitted_by', '=', 'submitter.uuid')
                ->leftJoin('users as approver', 'report_approvals.assigned_to', '=', 'approver.uuid')
                ->orderBy('report_approvals.approved_at', 'desc') // Order by approval date
                ->whereIn('report_approvals.status', ['pending', 'approved'])
                ->get();
        
            // Decode JSON data
            $approvals = $approvals->map(function ($approval) {
                $approval->report_data = json_decode($approval->report_data, true);
                return $approval;
            });
        
            $totalApprovals = $approvals->count();
            $approvedCount = $approvals->where('status', 'approved')->count();
        
            return view('approver.approved_statement_approver', compact('approvals', 'totalApprovals', 'approvedCount'));
        }
    
        public function collectors_statement_report_approver(){
        return view('approver.collectors_statement_report_approver');
    }
    
       public function collectors_receipt_approver(Request $request, $report_id)
        {
            // Fetch the specific report from the report_approvals table
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
                    'report_reviews.submitted_by as original_submitter_id',
                    'report_reviews.submitted_at as original_submitted_at',
                    'original_submitter.username as original_submitter_name',
                    'report_reviews.reviewed_at as original_reviewed_at'
                )
                ->leftJoin('users as submitter', 'report_approvals.submitted_by', '=', 'submitter.uuid')
                ->leftJoin('report_reviews', 'report_approvals.report_number', '=', 'report_reviews.report_number')
                ->leftJoin('users as original_submitter', 'report_reviews.submitted_by', '=', 'original_submitter.uuid')
                ->where('report_approvals.id', $report_id)
                ->first();
        
            // If no report is found, return a 404 error
            if (!$report) {
                abort(404, 'Report not found or not available for approval');
            }
        
            // Decode JSON report_data
            $report->report_data = json_decode($report->report_data, true);
        
            // Prepare data to pass to the view
            $data = [
                'report' => $report,
            ];
        
            // Return the view with the report data
            return view('approver.collectors_receipt_approver', $data);
        }
    
        public function cash_book_report_approver(){
        return view('approver.cash_book_report_approver');
    }

        public function checkbook_receipt_approver(){
        return view('approver.checkbook_receipt_approver');
    }
    
    public function dailyPaymentReceiptReportApprover(){
        return view('approver.daily-payment-receipt-report-approver');
    }

    public function dailyReceiptReportTypeApprover(){
        return view('approver.daily-receipt-report-type-approver');
    }
    
    public function updateReportStatus(Request $request)
    {
        try {
            $reportNumber = $request->input('report_number');
            $status = $request->input('status');
            $approvedAt = $request->input('approved_at');

            $updated = DB::table('report_approvals')
                ->where('report_number', $reportNumber)
                ->update([
                    'status' => $status,
                    'approved_at' => $approvedAt,
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json(['success' => true, 'message' => 'Report status updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Report not found or no changes made'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    
    
    public function rejectReport(Request $request, $report_id)
{
    try {
        $request->validate([
            'report_id' => 'required',
            'reason' => 'required|string|max:1000' // ✅ Validate rejection reason
        ]);

        // Ensure report exists
        $report = ReportApproval::findOrFail($report_id);

        // ✅ Update report_approvals
        $reportApproval = DB::table('report_approvals')
            ->where('id', $report_id)
            ->first();

        if ($reportApproval) {
            DB::table('report_approvals')
                ->where('id', $report_id)
                ->update([
                    'status' => 'rejected',
                    'approver_comments' => $request->reason,
                    'submitted_by' => auth('admin')->id(),
                    'approved_at' => now(),
                    'updated_at' => now()
                ]);
        } else {
            DB::table('report_approvals')->insert([
                'id' => $report_id,
                'status' => 'rejected',
                'approver_comments' => $request->reason,
                'submitted_by' => auth('admin')->id(),
                'approved_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // ✅ Update report_reviews (send back to reviewer)
        $reportReview = DB::table('report_reviews')
            ->where('id', $report_id)
            ->first();

        if ($reportReview) {
            DB::table('report_reviews')
                ->where('id', $report_id)
                ->update([
                    'status' => 'rejected',  
                    'reviewer_comments' => $request->reason, 
                    'updated_at' => now()
                ]);
        } else {
            DB::table('report_reviews')->insert([
                'id' => $report_id,
                'status' => 'rejected',
                'reviewer_comments' => $request->reason,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Report has been rejected and sent back to reviewer with reason.',
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







