<?php

declare(strict_types=1);

namespace Helicon\TypeConverter;

use Helicon\ObjectTypeParser\Parser;
use Helicon\TypeConverter\TypeCaster\ClassTypeCaster;
use Helicon\TypeConverter\TypeCaster\DateTimeCaster;
use Helicon\TypeConverter\TypeCaster\ScalarTypeCaster;
use PHPUnit\Framework\TestCase;
use Zend\Hydrator\ReflectionHydrator;

class ConverterTest extends TestCase
{
    public function testConvert(): void
    {
        $row = [
            'age' => '11',
            'year' => '3',
            'enable' => '0',
            'createdAt' => '2019-10-29 11:00:00',
            'friend' => [
                'id' => '21',
                'name' => 'taro yamda',
            ],
        ];

        $schemas = [
            'age' => [
                'type' => 'integer',
            ],
            'year' => [
                'type' => 'int',
            ],
            'enable' => [
                'type' => 'bool',
            ],
            'createdAt' => [
                'type' => \DateTime::class,
            ],
            'friend' => [
                'type' => Friend::class,
            ],
        ];

        $converter = $this->createConverter();
        $actual = ($converter)($row, $schemas);

        $this->assertSame(11, $actual['age']);
        $this->assertSame(3, $actual['year']);
        $this->assertFalse($actual['enable']);
        $this->assertInstanceOf(\DateTime::class, $actual['createdAt']);
        $this->assertInstanceOf(Friend::class, $actual['friend']);
    }

    public function testNestedClassConvert(): void
    {
        $row = [
            'friend' => [
                'id' => '21',
                'name' => 'taro yamda',
                'child' => [
                    'id' => '21',
                    'name' => 'taro yamda',
                ],
            ],
        ];

        $schemas = [
            'friend' => [
                'type' => Friend::class,
            ],
        ];

        $converter = $this->createConverter();
        $actual = ($converter)($row, $schemas);

        $this->assertInstanceOf(Friend::class, $actual['friend']->getChild());
    }

    private function createConverter(): ConverterInterface
    {
        $hydrator = new ReflectionHydrator();
        $resolver = new Resolver();
        $parser = new Parser();

        $resolver->addConverter(new ScalarTypeCaster());
        $resolver->addConverter(new DateTimeCaster());
        $resolver->addConverter(new ClassTypeCaster($resolver, $parser, $hydrator));

        return new Converter($resolver);
    }
}

class Friend
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var self
     */
    private $child;

    /**
     * @return Friend
     */
    public function getChild(): self
    {
        return $this->child;
    }
}
