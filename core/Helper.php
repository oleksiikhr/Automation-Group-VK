<?php declare(strict_types=1);

namespace core;

class Helper
{
    /**
     * Generate unique array.
     *
     * @param  int  $count
     * @param  int  $min
     * @param  int  $max
     * @return array
     */
    public static function generateRandomArray(int $count = 1, int $min = 1, int $max = 1): array {
        if ($count >= $max - $min + 1 || $max < $min || $count < 1) {
            return [];
        }

        $arr = [];
        $i = 0;

        while ($i < $count) {
            $number = mt_rand($min, $max);

            if (! in_array($number, $arr, true)) {
                $arr[] = $number;
                $i++;
            }
        }

        return $arr;
    }
}
