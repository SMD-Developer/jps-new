<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Application;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\ApplicationLog;
use App\Models\ActivityLog;
use App\Traits\LogsActivity;

class ApplicationController extends Controller
{
    use LogsActivity;
    
    public function approveApplication(Request $request, $id)
    {
        try {
            $application = Application::find($id);

            if (!$application) {
                return response()->json(['success' => false, 'message' => 'Application not found'], 404);
            }

            $currentApprover = auth('admin')->user();
            if ($currentApprover->role_id != '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d' && 
                ($currentApprover->role->name ?? '') != 'application_approver') {
                return response()->json(['success' => false, 'message' => 'Unauthorized role for this action'], 403);
            }
            
            $oldData = $application->toArray();
            
            
            
            $previousStatus = $application->status;
            $application->status = 'approved';
            $application->resubmitted_at = null;
            $application->save();
            
            $newData = $application->fresh()->toArray();
            
            
            
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
            
            
            ApplicationLog::create([
                'application_id' => $application->id,
                'user_id' => $currentApprover->uuid,
                'user_type' => 'admin_approver',
                'action' => 'approved',
                'status_from' => $previousStatus,
                'status_to' => 'approved',
                'remarks' => 'Application approved by approver',
                'additional_data' => [
                    'performed_by' => $currentApprover->username,
                    'approved_at' => now()->toDateTimeString(),
                ],
            ]);
            
            
            ActivityLog::create([
                'log_name' => 'application',
                'description' => 'Application approved by admin: ' . ($currentApprover->username ?? 'Unknown') . ' (Status changed from "' . $previousStatus . '" to "approved")',
                'event' => 'approved',
                'subject_type' => 'App\Models\Application',
                'subject_id' => $id,
                'properties' => $changes,
                'causer_type' => get_class($currentApprover),
                'causer_id' => $currentApprover->uuid,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Application approved by approver', [
                'application_id' => $application->id,
                'approved_by_uuid' => $currentApprover->uuid,
                'approved_by_username' => $currentApprover->username,
                'approved_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan diluluskan',
                'approved_by' => $currentApprover->username ?? $currentApprover->email,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Approve Application Error: ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'application_id' => $id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Server error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }


   

    private function generateApprovalLetter($application)
    {
        $data = [
            'application' => $application,
            'date' => now()->format('d/m/Y'),
            'recipient' => $application->applicant ?? 'Unknown Applicant',
            'address' => $application->address ?? 'N/A',
            'land_lot' => $application->land_lot ?? 'N/A',
        ];

        // Use 'letters.approval' or 'letters.approval_letters' based on your file name
        $pdf = Pdf::loadView('letters.approval', $data); // Adjust this to match your view file
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }


    
    public function rejectApplication(Request $request, $id)
    {
        $validated = $request->validate([
            'reason' => 'required|string',
        ]);

        $application = Application::find($id);

        if (!$application) {
            return response()->json(['success' => false, 'message' => 'Application not found'], 404);
        }

        $currentAdmin = auth('admin')->user();
        $userType = null;
        if ($currentAdmin->role_id == '9e032984-8ef0-4e00-b7b9-439679a4d1aa' || $currentAdmin->role->name == 'adminstaff') {
            $userType = 'admin_staff';
        } elseif ($currentAdmin->role_id == '9e2714f4-3b8b-46ab-8482-3919dc9b9f4d' || $currentAdmin->role->name == 'application_approver') {
            $userType = 'admin_approver';
        } else {
            return response()->json(['success' => false, 'message' => 'Unauthorized role for this action'], 403);
        }
        
        
         $oldData = $application->toArray();
        
        

        $previousStatus = $application->status;
        $application->status = 'rejected';
        $application->rejection_reason = $validated['reason'];
        if ($userType === 'admin_approver') {
            $application->rejected_at = now();
        }
        $application->resubmitted_at = null;
        $application->save();
        
        $newData = $application->fresh()->toArray();
        
        
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


        ApplicationLog::create([
            'application_id' => $application->id,
            'user_id' => $currentAdmin->uuid,
            'user_type' => $userType,
            'action' => 'rejected',
            'status_from' => $previousStatus,
            'status_to' => 'rejected',
            'remarks' => $validated['reason'],
            'additional_data' => ['performed_by' => $currentAdmin->username, 'rejected_at' => now()->toDateTimeString()],
        ]);
        
        
        
         ActivityLog::create([
            'log_name' => 'application',
            'description' => 'Application rejected by ' . ($userType === 'admin_staff' ? 'admin staff' : 'admin approver') . ': ' . ($currentAdmin->username ?? 'Unknown') . ' (Status changed from "' . $previousStatus . '" to "rejected")',
            'event' => 'rejected',
            'subject_type' => 'App\Models\Application',
            'subject_id' => $id,
            'properties' => $changes,
            'causer_type' => get_class($currentAdmin),
            'causer_id' => $currentAdmin->uuid,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        
         // **NEW: If approver rejects, create a system log to reset staff status to pending**
        if ($userType === 'admin_approver') {
            ApplicationLog::create([
                'application_id' => $application->id,
                'user_id' => null, // System generated
                'user_type' => 'admin_staff',
                'action' => 'reset_to_pending',
                'status_from' => 'approved',
                'status_to' => 'pending',
                'remarks' => 'Staff status reset to pending after approver rejection',
                'additional_data' => [
                    'performed_by' => 'System',
                    'triggered_by_rejection' => $currentAdmin->username,
                    'is_system_generated' => true,
                    'rejection_reason' => $validated['reason']
                ],
            ]);
            
            
            ActivityLog::create([
                'log_name' => 'application',
                'description' => 'System reset staff status to pending after approver rejection',
                'event' => 'system_reset',
                'subject_type' => 'App\Models\Application',
                'subject_id' => $id,
                'properties' => [
                    'triggered_by' => $currentAdmin->username,
                    'rejection_reason' => $validated['reason'],
                    'previous_status' => 'approved',
                    'new_status' => 'pending'
                ],
                'causer_type' => 'System',
                'causer_id' => null,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Application rejected successfully',
            'action_by' => $currentAdmin->role->name ?? 'admin',
        ], 200);
    }

}
