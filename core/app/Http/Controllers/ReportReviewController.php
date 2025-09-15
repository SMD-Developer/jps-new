<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

use App\Models\Application;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\ReportReview;
use App\Models\ReportApproval;
use App\Models\ApplicationLog;
use App\Models\ActivityLog;
use App\Traits\LogsActivity;



class ReportReviewController extends Controller
{
   
    
    
   public function sendToReviewer(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'report_number' => 'required|string',
                'report_data' => 'required|array',
                'total_amount' => 'required|string',
                'selected_receipts' => 'required|array',
                'start_date' => 'required|string', // Add validation for start_date
                'end_date' => 'required|string'    // Add validation for end_date
            ]);
    
            // Check if report already exists
            $existingReport = ReportReview::where('report_number', $request->report_number)->first();
            
            if ($existingReport && $existingReport->status !== 'rejected') {
                return response()->json([
                    'success' => false,
                    'message' => 'Report already submitted for review'
                ], 400);
            }
    
            // Get next available reviewer
            $reviewer = ReportReview::getNextReviewer();
            
            if (!$reviewer) {
                return response()->json([
                    'success' => false,
                    'message' => 'No reviewers available. Please contact administrator.'
                ], 400);
            }
    
            // Prepare clean report data without duplication but keep period dates
            $cleanReportData = [
                'currentDate' => $request->report_data['currentDate'] ?? null,
                'totalAmount' => $request->report_data['totalAmount'] ?? null,
                'formattedStartDate' => $request->report_data['formattedStartDate'] ?? null,
                'formattedEndDate' => $request->report_data['formattedEndDate'] ?? null,
                'selectedReceipts' => $request->report_data['selectedReceipts'] ?? [],
                // Keep the period information in report_data as well for easy reference
                'period' => [
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ]
            ];
    
            // Create or update report review record
            $reportReview = ReportReview::updateOrCreate(
                ['report_number' => $request->report_number],
                [
                    'report_data' => $cleanReportData,
                    'total_amount' => $request->total_amount,
                    'selected_receipts' => $request->selected_receipts,
                    'start_date' => $request->start_date, // Store separately
                    'end_date' => $request->end_date,     // Store separately
                    'submitted_by' => auth('admin')->id(),
                    'assigned_to' => $reviewer->uuid,
                    'status' => 'pending',
                    'submitted_at' => now(),
                    'reviewer_comments' => null,
                    'reviewed_at' => null
                ]
            );
    
            // Send notification to reviewer (optional)
            $this->notifyReviewer($reviewer, $reportReview);
    
            // Log the action
            Log::info('Report sent to reviewer', [
                'report_number' => $request->report_number,
                'submitted_by' => auth('admin')->id(),
                'assigned_to' => $reviewer->id,
                'period' => $request->start_date . ' to ' . $request->end_date
            ]);
    
            return response()->json([
                'success' => true,
                'message' => "Report successfully sent to reviewer: {$reviewer->name}",
                'reviewer_name' => $reviewer->name,
                'report_id' => $reportReview->id,
                'period' => $request->start_date . ' to ' . $request->end_date
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error sending report to reviewer: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send report to reviewer. Please try again.'
            ], 500);
        }
    }

    public function reviewerDashboard()
    {
        // Only allow users with reviewer role
        if (!auth()->user()->hasRole('reviewer')) {
            abort(403, 'Access denied. Reviewer role required.');
        }

        $pendingReports = ReportReview::where('assigned_to', auth('admin')->id())
            ->where('status', 'pending')
            ->orderBy('submitted_at', 'asc')
            ->paginate(10);

        $reviewedReports = ReportReview::where('assigned_to', auth('admin')->id())
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('reviewed_at', 'desc')
            ->paginate(10);

        return view('reviewer.dashboard', compact('pendingReports', 'reviewedReports'));
    }

    public function reviewReport(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'comments' => 'nullable|string|max:1000'
        ]);

        $reportReview = ReportReview::findOrFail($id);

        // Check if current user is the assigned reviewer
        if ($reportReview->assigned_to !== auth('admin')->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to review this report'
            ], 403);
        }

        // Update report status
        $reportReview->update([
            'status' => $request->action === 'approve' ? 'approved' : 'rejected',
            'reviewer_comments' => $request->comments,
            'reviewed_at' => now()
        ]);

        // Notify the submitter
        $this->notifySubmitter($reportReview);

        return response()->json([
            'success' => true,
            'message' => "Report {$request->action}d successfully"
        ]);
    }

    private function notifyReviewer($reviewer, $reportReview)
    {
        // You can implement email notifications here
        // Mail::to($reviewer->email)->send(new ReportAssignedNotification($reportReview));
        
        // Or create in-app notifications
        // Notification::create([
        //     'user_id' => $reviewer->id,
        //     'type' => 'report_assigned',
        //     'data' => [
        //         'message' => "New report {$reportReview->report_number} assigned for review",
        //         'report_id' => $reportReview->id
        //     ]
        // ]);
    }

    private function notifySubmitter($reportReview)
    {
        // Notify the submitter about review result
        // Similar to notifyReviewer method
    }
    
    
    public function sendToApprover(Request $request, $report_id)
    {
        // Validate the request
        $validated = $request->validate([
            'report_id' => 'required|integer',
            'report_number' => 'required|string',
            'total_amount' => 'required|string',
            'current_date' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'selected_receipts' => 'required|array',
            'report_data' => 'required|array',
        ]);

        // Find the report in ReportReview
        $report = ReportReview::findOrFail($report_id);
        if ($report->report_number !== $validated['report_number']) {
            return response()->json(['success' => false, 'message' => 'Invalid report number'], 400);
        }

        // Update ReportReview status
        $report->update([
            'status' => 'approved', // Or 'forwarded_to_approver'
            'reviewed_at' => now(),
        ]);

        // Get next approver
        $approver = ReportApproval::getNextApprover();
        if (!$approver) {
            return response()->json(['success' => false, 'message' => 'No approver available'], 400);
        }

        // Create new ReportApproval record
        ReportApproval::create([
            'report_number' => $validated['report_number'],
            'report_data' => $validated['report_data'],
            'submitted_by' => auth('admin')->id(),
            'assigned_to' => $approver->uuid,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Report forwarded to approver successfully',
        ]);
    }

}