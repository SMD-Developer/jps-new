<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'third_party_id',
        'status',
        'admin_uuid',  
        'admin_notes',
        'receipt_file_path',
        'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Relationships
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function thirdParty()
    {
        return $this->belongsTo(ThirdPartyUser::class, 'third_party_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_uuid', 'uuid');  
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}