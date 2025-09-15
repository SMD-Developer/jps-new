<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidModel;

class Payment extends Model
{
    use UuidModel;

    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'application_id',
        'payment_date',
        'amount',
        'method',
        'payment_status',
        'transaction_id',
        'receipt_number',
        'payment_rejection_reason',
        'receipt_path',
        'cheque_number',
        'cheque_date',
        'cheque_bank_name',
        'bank_transfer_transaction_id',
        'transfer_date',
        'from_bank',
        'account_number',
        'bank_transfer_receipt_path',
        'gateway_transaction_id',
        'payment_gateway',
        'gateway_response',
        'admin_notes',
        'currency',
        'test_case',
        'bank_code',
        'bank_name',
        'buyer_bank_id',
        'buyer_email',
        'buyer_name',
        'seller_order_no',
        'seller_ex_order_no',
        'fpx_transaction_id',
        'fpx_checksum',
        'status_message',
        'user_id'
    ];
    
    
    protected $casts = [
        'payment_date' => 'date',
        'cheque_date' => 'date',
        'transfer_date' => 'date',
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
    ];
    
    protected $attributes = [
        'currency' => 'MYR',
        'payment_status' => 'pending'
    ];
    
    public function isFpxPayment()
    {
        return $this->method === 'FPX' || $this->payment_gateway === 'FPX';
    }

    // Helper method to get formatted amount
    public function getFormattedAmountAttribute()
    {
        return 'RM ' . number_format($this->amount, 2);
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function paymentLogs()
    {
        return $this->hasMany(PaymentLog::class, 'payment_uuid', 'uuid');
    }
}