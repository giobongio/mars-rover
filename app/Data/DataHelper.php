<?php

namespace App\Data;

trait DataHelper
{
    public static function toAssociativeArray(mixed $data): mixed
    {
        // Only process if it's an object or array being passed to the function
        if(is_object($data) || is_array($data)) {
            $dataArray = (array) $data;
            foreach($dataArray as &$dataItem) {
                $dataItem = self::toAssociativeArray($dataItem);
            }

            return $dataArray;
        }
         
        // Otherwise (i.e. for scalar values) return without modification
        return $data;
    }

    public function jsonSerialize(): string|false
    {
        return json_encode(get_object_vars($this));
    }
}
