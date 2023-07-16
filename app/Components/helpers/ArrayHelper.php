<?php

namespace App\Components\helpers;

class ArrayHelper {

    public static function getKeyOfColumnValue($array, $column, $columnValue) {
        foreach ($array as $key => $_) {
            if ($_[$column] == $columnValue) {
                return $key;
            }
        }

        return false;
    }

    public static function getRandomValue(array $arr) {
        return array_values($arr)[random_int(0, count($arr) - 1)];
    }

    public static function indexByKeyMultiple($array, $column) {
        $res = [];
        foreach ($array as $item) {
            $res[$item[$column]][] = $item;
        }

        return $res;
    }

    /**
     * Extract column with preserving the array's keys
     * @param array $arr
     * @param $column
     * @return array
     */
    public static function extractColumn(array $arr, $column) {
        $res = [];
        foreach ($arr as $key => $item) {
            $res[$key] = $item[$column];
        }

        return $res;
    }
}
