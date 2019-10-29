<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use Helicon\TypeConverter\Exception\TypeCasterException;
use PHPUnit\Framework\TestCase;

class NumberTypeCasterTest extends TestCase
{
    public function testSupports(): void
    {
        $this->assertTrue((new NumberTypeCaster())->supports('number'));
        $this->assertFalse((new NumberTypeCaster())->supports('int'));
    }

    public function testConvert(): void
    {
        $this->assertSame(123, (new NumberTypeCaster())->convert('123', 'number'));
        $this->assertSame(123.3, (new NumberTypeCaster())->convert('123.3', 'number'));
    }

    public function typeConvertExcpetion(): void
    {
        $this->expectException(TypeCasterException::class);
        (new NumberTypeCaster())->convert('abcefg', 'number');
    }
}
