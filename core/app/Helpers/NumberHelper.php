<?php

namespace App\Helpers;

class NumberHelper
{
    public static function numberToMalayWords($number)
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
        $hundreds = 'Ratus';
        $thousands = 'Ribu';
        $millions = 'Juta';

        $number = (int)$number; // Convert to integer
        if ($number === 0) {
            return 'Sifar';
        }

        $words = '';

        // Millions
        if ($number >= 1000000) {
            $millions_part = floor($number / 1000000);
            $words .= self::numberToMalayWords($millions_part) . ' ' . $millions . ' ';
            $number %= 1000000;
        }

        // Thousands
        if ($number >= 1000) {
            $thousands_part = floor($number / 1000);
            $words .= self::numberToMalayWords($thousands_part) . ' ' . $thousands . ' ';
            $number %= 1000;
        }

        // Hundreds
        if ($number >= 100) {
            $hundreds_part = floor($number / 100);
            $words .= $ones[$hundreds_part] . ' ' . $hundreds . ' ';
            $number %= 100;
        }

        // Tens and Ones
        if ($number > 0) {
            if ($number < 20) {
                $words .= $ones[$number];
            } else {
                $tens_part = floor($number / 10);
                $ones_part = $number % 10;
                $words .= $tens[$tens_part];
                if ($ones_part > 0) {
                    $words .= ' ' . $ones[$ones_part];
                }
            }
        }

        return trim($words);
    }
}