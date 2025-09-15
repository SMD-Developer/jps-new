<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportApproval extends Model
{
    use HasFactory;

    protected $table = 'report_approvals';

    protected $fillable = [
        'report_number',
        'report_data',
        'submitted_by',
        'assigned_to',
        'status',
        'approver_comments',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'report_data' => 'array',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Get next available approver
    public static function getNextApprover()
    {
        // Get users with 'approver' role
        $approvers = User::whereHas('role', function($query) {
            $query->where('name', 'approver');
        })->get();
    
        if ($approvers->isEmpty()) {
            return null;
        }
    
        // Round-robin assignment: find approver with least pending approvals
        $approverWithLeastApprovals = $approvers->sortBy(function($approver) {
            return $approver->assignedApprovals()->where('status', 'pending')->count();
        })->first();
    
        return $approverWithLeastApprovals;
    }

    // Relationship to access assigned approvals for a user
    public function scopeAssignedApprovals($query)
    {
        return $query->where('assigned_to', $this->id);
    }
}
