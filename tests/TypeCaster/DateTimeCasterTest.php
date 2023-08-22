<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use PHPUnit\Framework\TestCase;

final class DateTimeCasterTest extends TestCase
{
    public function testConvert(): void
    {
        $this->assertInstanceOf(\DateTime::class, (new DateTimeCaster())->convert('2016-11-12 00:00:00', '\DateTime'));
        $this->assertInstanceOf(\DateTimeImmutable::class, (new DateTimeCaster())->convert('2016-11-12 00:00:00', '\DateTimeImmutable'));
    }

    public function testSupported(): void
    {
        $dateTimeCaster = new DateTimeCaster();
        $this->assertTrue($dateTimeCaster->supports('\DateTime'));
        $this->assertTrue($dateTimeCaster->supports('\DateTimeImmutable'));
    }
}
