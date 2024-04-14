<?php

namespace Tests\Unit\Data;

use App\Data\DataHelper;
use Tests\TestCase;

class DataHelperTest extends TestCase
{
    use DataHelper;

    public function test_boolToString_getCorrectString()
    {
        $data = true;
        $this->assertEquals('true', DataHelper::boolToString($data));
    }

    public function test_serialize_outputSerializedData()
    {
        $data = (object) [
            'name' => 'John',
            'isMale' => true,
            'age' => 43
        ];

        $serializedData = '{"name":"' . $data->name . '","isMale":' . DataHelper::boolToString($data->isMale) . ',"age":' . $data->age . '}';
        $this->assertEquals($serializedData, DataHelper::jsonSerialize($data));
    }

    public function test_convertAssociativeArrayToAssociativeArray_getSameData()
    {
        $data = [
            'name' => 'John',
            'isMale' => true,
            'age' => 43
        ];

        $this->assertEquals($data, DataHelper::convertToAssociativeArray($data));
    }

    public function test_convertObjectToAssociativeArray_getConvertedData()
    {
        $data = [
            'name' => 'John',
            'isMale' => true,
            'age' => 43
        ];

        $this->assertEquals((array) $data, DataHelper::convertToAssociativeArray($data));
    }

    public function test_convertScalarToAssociativeArray_getSameData()
    {
        $data = 'John';
        $this->assertEquals($data, DataHelper::convertToAssociativeArray($data));
    }
}
