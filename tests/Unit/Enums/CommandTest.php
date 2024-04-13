<?php

namespace Tests\Unit\Enums;

use App\Enums\Command;
use Tests\TestCase;

class CommandTest extends TestCase
{
    public function test_invalidValue_getNullEnum(): void
    {
        $value = "X";
        
        $command = Command::getEnum($value);
        $this->assertEmpty($command);
    }

    public function test_validValue_getCorrectEnum(): void
    {
        $expectedCommand = Command::MOVE_FORWARD;
        
        $command = Command::getEnum($expectedCommand->value);
        $this->assertEquals($expectedCommand, $command);
    }

    public function test_validValueLowercase_getCorrectEnum(): void
    {
        $expectedCommand = Command::ROTATE_RIGHT;
        
        $command = Command::getEnum(strtolower($expectedCommand->value));
        $this->assertEquals($expectedCommand, $command);
    }

    public function test_invalidValue_isInvalid(): void
    {
        $value = "X";
        
        $isValid = Command::isValid($value);
        $this->assertEquals(false, $isValid);
    }

    public function test_validValue_isValid(): void
    {
        $command = Command::MOVE_BACKWARD;
        
        $isValid = Command::isValid($command->value);
        $this->assertEquals(true, $isValid);
    }
}
