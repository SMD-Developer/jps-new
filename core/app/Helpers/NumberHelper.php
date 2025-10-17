<?php

namespace App\Helpers;

class NumberHelper
{
    public static function numberToMalayWords($amount)
    {
        // Format amount to always have two decimals
        $amount = number_format((float)$amount, 2, '.', '');
        list($ringgit, $sen) = explode('.', $amount);

        $words = '';
        $ringgit = (int)$ringgit;
        $sen = (int)$sen;

        // Convert ringgit part
        if ($ringgit > 0) {
            $words .= self::convertNumberToWords($ringgit) . ' Ringgit';
        }

        // Convert sen part
        if ($sen > 0) {
            if ($ringgit > 0) {
                $words .= ' dan ';
            }
            $words .= self::convertNumberToWords($sen) . ' Sen';
        }

        // Handle zero case
        if ($ringgit == 0 && $sen == 0) {
            $words = 'Sifar Ringgit';
        }

        return strtoupper(trim($words));
    }

    private static function convertNumberToWords($number)
    {
        $ones = [
            0 => '', 1 => 'Satu', 2 => 'Dua', 3 => 'Tiga', 4 => 'Empat',
            5 => 'Lima', 6 => 'Enam', 7 => 'Tujuh', 8 => 'Lapan', 9 => 'Sembilan',
            10 => 'Sepuluh', 11 => 'Sebelas', 12 => 'Dua Belas', 13 => 'Tiga Belas',
            14 => 'Empat Belas', 15 => 'Lima Belas', 16 => 'Enam Belas',
            17 => 'Tujuh Belas', 18 => 'Lapan Belas', 19 => 'Sembilan Belas'
        ];

        $tens = [
            2 => 'Dua Puluh', 3 => 'Tiga Puluh', 4 => 'Empat Puluh', 5 => 'Lima Puluh',
            6 => 'Enam Puluh', 7 => 'Tujuh Puluh', 8 => 'Lapan Puluh', 9 => 'Sembilan Puluh'
        ];

        if ($number == 0) {
            return 'Sifar';
        }

        $words = '';

        if ($number >= 1000000) {
            $words .= self::convertNumberToWords(floor($number / 1000000)) . ' Juta ';
            $number %= 1000000;
        }

        if ($number >= 1000) {
            $words .= self::convertNumberToWords(floor($number / 1000)) . ' Ribu ';
            $number %= 1000;
        }

        if ($number >= 100) {
            $words .= self::convertNumberToWords(floor($number / 100)) . ' Ratus ';
            $number %= 100;
        }

        if ($number > 0) {
            if ($number < 20) {
                $words .= $ones[$number];
            } else {
                $words .= $tens[floor($number / 10)];
                if ($number % 10 > 0) {
                    $words .= ' ' . $ones[$number % 10];
                }
            }
        }

        return trim($words);
    }
}
