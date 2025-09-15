<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OtpVerification extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'type',
        'is_verified',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    /**
     * Generate a new OTP for the given email
     */
    public static function generateOtp($email, $type = 'registration')
    {
        // Delete any existing unverified OTPs for this email and type
        self::where('email', $email)
            ->where('type', $type)
            ->where('is_verified', false)
            ->delete();

        // Generate 6-digit OTP
        $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        return self::create([
            'email' => $email,
            'otp' => $otp,
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    /**
     * Verify OTP
     */
    public static function verifyOtp($email, $otp, $type = 'registration')
    {
        $otpRecord = self::where('email', $email)
            ->where('otp', $otp)
            ->where('type', $type)
            ->where('is_verified', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($otpRecord) {
            $otpRecord->update(['is_verified' => true]);
            return true;
        }

        return false;
    }

    /**
     * Check if OTP is expired
     */
    public function isExpired()
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    /**
     * Clean up expired OTPs
     */
    public static function cleanupExpired()
    {
        self::where('expires_at', '<', Carbon::now())->delete();
    }
}