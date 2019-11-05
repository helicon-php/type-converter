<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster\External;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

class CarbonTypeCasterTest extends TestCase
{
    public function testConvert(): void
    {
        $this->assertInstanceOf(Carbon::class, (new CarbonTypeCaster())->convert('2016-11-12 00:00:00', 'Carbon\Carbon'));
        $this->assertInstanceOf(CarbonImmutable::class, (new CarbonTypeCaster())->convert('2016-11-12 00:00:00', 'Carbon\CarbonImmutable'));
    }

    public function testSupported(): void
    {
        $dateTimeCaster = new CarbonTypeCaster();
        $this->assertTrue($dateTimeCaster->supports('Carbon\Carbon'));
        $this->assertTrue($dateTimeCaster->supports('Carbon\CarbonImmutable'));
    }
}
