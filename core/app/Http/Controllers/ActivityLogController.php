<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog; 
use Illuminate\Support\Str;

class ActivityLogController extends Controller
{
    
    
    
    public function index(Request $request)
    {
        try {
            $query = ActivityLog::query();
            
            // Filter by log name (e.g., 'application', 'claim_contribution')
            if ($request->filled('log_name')) {
                $query->where('log_name', $request->log_name);
            }
            
            // Filter by event type (e.g., 'created', 'updated', 'status_updated')
            if ($request->filled('event')) {
                $query->where('event', $request->event);
            }
            
            // Filter by subject ID (specific record ID)
            if ($request->filled('subject_id')) {
                $query->where('subject_id', $request->subject_id);
            }
            
            // Filter by subject type (model type)
            if ($request->filled('subject_type')) {
                $query->where('subject_type', $request->subject_type);
            }
            
            // Filter by causer (admin who performed the action)
            if ($request->filled('causer_id')) {
                $query->where('causer_id', $request->causer_id);
            }
            
            // Filter by date range
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            // Search in description
            if ($request->filled('search')) {
                $query->where('description', 'like', '%' . $request->search . '%');
            }
            
            // Order by latest first
            $query->orderBy('created_at', 'desc');
            
            // Paginate results
            $perPage = $request->input('per_page', 15);
            $logs = $query->paginate($perPage);
            
            // Get filter options for dropdowns
            $logNames = ActivityLog::select('log_name')
                ->distinct()
                ->whereNotNull('log_name')
                ->pluck('log_name');
                
            $events = ActivityLog::select('event')
                ->distinct()
                ->whereNotNull('event')
                ->pluck('event');
                
            $subjectTypes = ActivityLog::select('subject_type')
                ->distinct()
                ->whereNotNull('subject_type')
                ->pluck('subject_type');
    
            return view('admin.log-activities', compact('logs', 'logNames', 'events', 'subjectTypes'));
            
        } catch (\Exception $e) {
            \Log::error('Error retrieving activity logs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to retrieve activity logs');
        }
    }

    /**
     * Retrieve activity logs with filtering and pagination
     */
    public function getLogs(Request $request)
    {
        try {
            $query = ActivityLog::query();

            // Filter by log name (e.g., 'application', 'claim_contribution')
            if ($request->filled('log_name')) {
                $query->where('log_name', $request->log_name);
            }

            // Filter by event type (e.g., 'created', 'updated', 'status_updated')
            if ($request->filled('event')) {
                $query->where('event', $request->event);
            }

            // Filter by subject ID (specific record ID)
            if ($request->filled('subject_id')) {
                $query->where('subject_id', $request->subject_id);
            }

            // Filter by subject type (model type)
            if ($request->filled('subject_type')) {
                $query->where('subject_type', $request->subject_type);
            }

            // Filter by causer (admin who performed the action)
            if ($request->filled('causer_id')) {
                $query->where('causer_id', $request->causer_id);
            }

            // Filter by date range
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Search in description
            if ($request->filled('search')) {
                $query->where('description', 'like', '%' . $request->search . '%');
            }

            // Order by latest first
            $query->orderBy('created_at', 'desc');

            // Paginate results
            $perPage = $request->input('per_page', 15);
            $logs = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $logs->items(),
                'pagination' => [
                    'current_page' => $logs->currentPage(),
                    'last_page' => $logs->lastPage(),
                    'per_page' => $logs->perPage(),
                    'total' => $logs->total(),
                    'from' => $logs->firstItem(),
                    'to' => $logs->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error retrieving activity logs: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve activity logs'
            ], 500);
        }
    }

    /**
     * Get activity logs for a specific record
     */
    public function getLogsByRecord(Request $request, $subjectType, $subjectId)
    {
        try {
            $logs = ActivityLog::where('subject_type', $subjectType)
                ->where('subject_id', $subjectId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $logs,
                'count' => $logs->count()
            ]);

        } catch (\Exception $e) {
            \Log::error('Error retrieving logs for record: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve logs for this record'
            ], 500);
        }
    }

    /**
     * Get activity log statistics/summary
     */
    public function getLogStats(Request $request)
    {
        try {
            $stats = [
                'total_logs' => ActivityLog::count(),
                'logs_today' => ActivityLog::whereDate('created_at', today())->count(),
                'logs_this_week' => ActivityLog::whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->count(),
                'logs_this_month' => ActivityLog::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ];

            // Get top events
            $topEvents = ActivityLog::select('event', DB::raw('count(*) as count'))
                ->groupBy('event')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get();

            // Get top log names
            $topLogNames = ActivityLog::select('log_name', DB::raw('count(*) as count'))
                ->groupBy('log_name')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'top_events' => $topEvents,
                'top_log_names' => $topLogNames
            ]);

        } catch (\Exception $e) {
            \Log::error('Error retrieving log statistics: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve log statistics'
            ], 500);
        }
    }

    /**
     * Get detailed information for a specific log entry
     */
    public function getLogDetails($id)
    {
        try {
            $log = ActivityLog::find($id);

            if (!$log) {
                return response()->json([
                    'success' => false,
                    'message' => 'Log entry not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $log
            ]);

        } catch (\Exception $e) {
            \Log::error('Error retrieving log details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve log details'
            ], 500);
        }
    }

    /**
     * Delete old activity logs (cleanup function)
     */
    public function cleanupLogs(Request $request)
    {
        try {
            $validated = $request->validate([
                'days_old' => 'required|integer|min:30' // Minimum 30 days to prevent accidental deletion
            ]);

            $cutoffDate = now()->subDays($validated['days_old']);
            
            $deletedCount = ActivityLog::where('created_at', '<', $cutoffDate)->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} old log entries",
                'deleted_count' => $deletedCount
            ]);

        } catch (\Exception $e) {
            \Log::error('Error cleaning up logs: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to cleanup old logs'
            ], 500);
        }
    }
}