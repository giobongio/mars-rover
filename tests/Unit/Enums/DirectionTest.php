<?php

namespace Tests\Unit\Enums;

use App\Enums\Direction;
use Tests\TestCase;

class DirectionTest extends TestCase
{
    public function test_invalidValue_getNullEnum(): void
    {
        $value = "X";
        
        $direction = Direction::getEnum($value);
        $this->assertEmpty($direction);
    }

    public function test_validValue_getCorrectEnum(): void
    {
        $expectedDirection = Direction::WEST;
        
        $direction = Direction::getEnum($expectedDirection->value);
        $this->assertEquals($expectedDirection, $direction);
    }

    public function test_invalidValue_isInvalid(): void
    {
        $value = "X";
        
        $isValid = Direction::isValid($value);
        $this->assertEquals(false, $isValid);
    }

    public function test_validValue_isValid(): void
    {
        $direction = Direction::WEST;
        
        $isValid = Direction::isValid($direction->value);
        $this->assertEquals(true, $isValid);
    }
}
