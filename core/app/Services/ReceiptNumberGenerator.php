<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class ReceiptNumberGenerator
{
    public const LOCK_NAME = 'jps_receipt_sequence';

    public static function reserve(): ReceiptNumberGuard
    {
        $lock = DB::selectOne('SELECT GET_LOCK(?, 10) AS locked', [self::LOCK_NAME]);

        if (!$lock || (int) $lock->locked !== 1) {
            throw new RuntimeException('Unable to generate a receipt number. Please try again.');
        }

        try {
            $row = DB::table('payments')
                ->where('receipt_number', 'like', '%JPSSEL%')
                ->selectRaw('MAX(CAST(RIGHT(receipt_number, 6) AS UNSIGNED)) as max_seq')
                ->first();

            $nextSequence = ((int) ($row->max_seq ?? 0)) + 1;

            if ($nextSequence > 999999) {
                throw new RuntimeException('Receipt number sequence is full.');
            }

            $now = Carbon::now();
            $receiptNumber = $now->format('y') . 'JPSSEL' . $now->format('md') . str_pad((string) $nextSequence, 6, '0', STR_PAD_LEFT);

            return new ReceiptNumberGuard($receiptNumber);
        } catch (Throwable $e) {
            DB::select('SELECT RELEASE_LOCK(?)', [self::LOCK_NAME]);
            throw $e;
        }
    }
}

class ReceiptNumberGuard
{
    public string $number;

    private bool $released = false;

    public function __construct(string $number)
    {
        $this->number = $number;
    }

    public function release(): void
    {
        if ($this->released) {
            return;
        }

        $this->released = true;

        try {
            DB::select('SELECT RELEASE_LOCK(?)', [ReceiptNumberGenerator::LOCK_NAME]);
        } catch (Throwable $e) {
        }
    }

    public function __destruct()
    {
        $this->release();
    }
}
