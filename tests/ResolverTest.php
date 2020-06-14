<?php

declare(strict_types=1);

namespace Helicon\TypeConverter;

use Helicon\TypeConverter\Exception\TypeCasterException;
use Helicon\TypeConverter\TypeCaster\TypeCasterInterface;
use PHPUnit\Framework\TestCase;

class ResolverTest extends TestCase
{
    public function testResolve(): void
    {
        $value = 'value';
        $type = 'type';

        $typeCaster = $this->prophesize(TypeCasterInterface::class);
        $typeCaster->convert($value, $type)
            ->willReturn($value);

        $typeCaster->supports($type)
            ->willReturn(true);

        $resolver = new Resolver();
        $resolver->addTypeCaster($typeCaster->reveal());

        $resolver->resolve($type);

        $typeCaster->supports($type)
            ->shouldHaveBeenCalledTimes(1);
    }

    public function testTypeCasterException(): void
    {
        $this->expectException(TypeCasterException::class);
        $resolver = new Resolver();
        $resolver->resolve('abc');
    }
}
