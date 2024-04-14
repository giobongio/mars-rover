<?php

namespace App\Data;

trait DataHelper
{
    public static function convertToAssociativeArray(mixed $data): mixed
    {
        // Only process if it's an object or array being passed to the function
        if(is_object($data) || is_array($data)) {
            $dataArray = (array) $data;
            foreach($dataArray as &$dataItem) {
                $dataItem = self::convertToAssociativeArray($dataItem);
            }

            return $dataArray;
        }
         
        // Otherwise (i.e. for scalar values) return without modification
        return $data;
    }

    public static function jsonSerialize(object $data): string|false
    {
        return json_encode(get_object_vars($data));
    }

    public static function boolToString(bool $data): string
    {
        return $data ? 'true' : 'false';
    }
}
