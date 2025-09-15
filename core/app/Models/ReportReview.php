<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ReportReview extends Model
{
    protected $fillable = [
        'report_number',
        'report_data',
        'submitted_by',
        'assigned_to',
        'status',
        'reviewer_comments',
        'submitted_at',
        'reviewed_at'
    ];

    protected $casts = [
        'report_data' => 'array',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime'
    ];

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Get next available reviewer
    public static function getNextReviewer()
    {
        // Get users with 'reviewer' role
        $reviewers = User::whereHas('role', function($query) {
            $query->where('name', 'reviewer');
        })->get();

        if ($reviewers->isEmpty()) {
            return null;
        }

        // Round-robin assignment: find reviewer with least pending reports
        $reviewerWithLeastReports = $reviewers->sortBy(function($reviewer) {
            return $reviewer->assignedReviews()->where('status', 'pending')->count();
        })->first();

        return $reviewerWithLeastReports;
    }
    
    public function scopeAssignedReviews($query)
    {
        return $query->where('assigned_to', $this->id);
    }
}