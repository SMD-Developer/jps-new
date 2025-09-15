<?php

namespace App\Helpers;

use DateTime;
use DateTimeInterface;
use Exception;

class DateHelper
{
    public static function formatMalayDate($date = null)
    {
        if (!$date) {
            return '10 hb September 2024';
        }

        if (!$date instanceof DateTimeInterface) {
            try {
                $date = new DateTime($date);
            } catch (Exception $e) {
                return '10 hb September 2024';
            }
        }

        $malayMonths = [
            1 => 'Januari', 
            2 => 'Februari', 
            3 => 'Mac', 
            4 => 'April', 
            5 => 'Mei', 
            6 => 'Jun',
            7 => 'Julai', 
            8 => 'Ogos', 
            9 => 'September',
            10 => 'Oktober', 
            11 => 'November', 
            12 => 'Disember'
        ];
        
        return $date->format('d').' hb '.$malayMonths[(int)$date->format('n')].' '.$date->format('Y');
    }
}