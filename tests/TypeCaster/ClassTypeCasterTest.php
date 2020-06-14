<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use Helicon\ObjectTypeParser\Parser;
use Helicon\TypeConverter\Resolver;
use Laminas\Hydrator\ReflectionHydrator;
use PHPUnit\Framework\TestCase;

class ClassTypeCasterTest extends TestCase
{
    public function testConvert(): void
    {
        $data = [
            'id' => '123',
            'name' => 'Jiro Yamamoto',
            'enable' => true,
            'weight' => '3.23',
            'createdAt' => '2019-11-19 03:00:00',
        ];

        $typeCaster = $this->createTypeCaster();

        /** @var User $actual */
        $actual = $typeCaster->convert($data, User::class);
        $this->assertInstanceOf(User::class, $actual);
        $this->assertSame(123, $actual->getId());
        $this->assertSame('Jiro Yamamoto', $actual->getName());
        $this->assertTrue($actual->isEnable());
        $this->assertSame(3.23, $actual->getWeight());
        $this->assertInstanceOf(\DateTime::class, $actual->getCreatedAt());
        $this->assertSame('2019-11-19 03:00:00', $actual->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    public function testDateTimeConvert(): void
    {
        $typeCaster = $this->createTypeCaster();
        $this->assertFalse($typeCaster->supports('\DateTime'));
        $this->assertFalse($typeCaster->supports('DateTime'));
    }

    private function createTypeCaster(): ClassTypeCaster
    {
        $resolver = new Resolver();
        $resolver->addTypeCaster(new DateTimeCaster());
        $resolver->addTypeCaster(new ScalarTypeCaster());

        $reflectionHydrator = new ReflectionHydrator();

        $parser = new Parser();

        return new ClassTypeCaster($resolver, $parser, $reflectionHydrator);
    }
}

class User
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
     * @var bool
     */
    private $enable;

    /**
     * @var float
     */
    private $weight;

    /**
     * @var \DateTime
     */
    private $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isEnable(): bool
    {
        return $this->enable;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
