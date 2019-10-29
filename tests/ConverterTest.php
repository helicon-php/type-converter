<?php

declare(strict_types=1);

namespace Helicon\TypeConverter;

use Helicon\TypeConverter\TypeCaster\TypeCasterInterface;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function testConvert(): void
    {
        $row = [
            'age' => '11',
        ];

        $schemas = [
            'age' => [
                'type' => 'integer',
            ],
        ];

        $resolver = $this->prophesize(Resolver::class);
        $typeCaster = $this->prophesize(TypeCasterInterface::class);

        $resolver->resolve('integer')
            ->willReturn($typeCaster);

        $typeCaster->convert('11', 'integer')
            ->willReturn(11);

        $converter = new Converter($resolver->reveal());
        $converter->__invoke($row, $schemas);

        $resolver->resolve('integer')
            ->shouldHaveBeenCalledTimes(1);

        $typeCaster->convert('11', 'integer')
            ->shouldHaveBeenCalledTimes(1);
    }
}
