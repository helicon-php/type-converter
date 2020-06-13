<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use PHPUnit\Framework\TestCase;

class ScalarTypeCasterTest extends TestCase
{
    /**
     * @dataProvider dpSupports
     */
    public function testSupports(string $type, bool $expected): void
    {
        $typeCaster = new ScalarTypeCaster();
        $this->assertSame($expected, $typeCaster->supports($type));
    }

    /**
     * @dataProvider dpConvert
     *
     * @param $value
     * @param $expected
     */
    public function testConvert($value, string $type, $expected): void
    {
        $typeCaster = new ScalarTypeCaster();
        $actual = $typeCaster->convert($value, $type);
        $this->assertSame($expected, $actual);
    }

    public function dpSupports(): array
    {
        return [
            [
                'boolean',
                true,
            ],
            [
                'bool',
                true,
            ],
            [
                'integer',
                true,
            ],
            [
                'int',
                true,
            ],
            [
                'string',
                true,
            ],
            [
                'float',
                true,
            ],
            [
                'double',
                true,
            ],
            [
                'ing',
                false,
            ],
        ];
    }

    public function dpConvert(): array
    {
        return [
            [
                '123',
                'int',
                123,
            ],
            [
                '123',
                'integer',
                123,
            ],
            [
                'true',
                'bool',
                true,
            ],
            [
                '1',
                'bool',
                true,
            ],
            [
                '0',
                'bool',
                false,
            ],
            [
                '12.3',
                'float',
                12.3,
            ],
            [
                '12.3',
                'double',
                12.3,
            ],
        ];
    }
}
