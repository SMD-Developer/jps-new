<?php

namespace App\Helpers;

class LandHelper
{
    public static function displayHectare($landArea, $landUnit, $storedHectare = null)
    {
        $area = (float) $landArea;
        $unit = (string) $landUnit;

        if ($area > 0 && $unit === '1') {
            $hectares = $area / 10000;
        } elseif ($area > 0 && $unit === '2') {
            $hectares = $area / 2.47105;
        } elseif ($area > 0 && $unit === '3') {
            $hectares = $area;
        } else {
            $hectares = (float) $storedHectare;
        }

        return number_format($hectares, 2);
    }
}
