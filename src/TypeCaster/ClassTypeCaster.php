<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use Helicon\ObjectTypeParser\ParserInterface;
use Helicon\TypeConverter\Exception\TypeCasterException;
use Helicon\TypeConverter\Resolver;
use Laminas\Hydrator\ReflectionHydrator;

final class ClassTypeCaster implements TypeCasterInterface
{
    public function __construct(
        private readonly Resolver $resolver,
        private readonly ParserInterface $parser,
        private readonly ReflectionHydrator $reflectionHydrator
    ) {
    }

    /**
     * @throws \ReflectionException
     */
    public function convert(mixed $value, string $type): object
    {
        if (!\is_array($value)) {
            throw new TypeCasterException('ClassTypeCaster is need for array value');
        }

        $refClass = new \ReflectionClass($type);
        $schemas = ($this->parser)($type);

        $results = [];
        foreach ($value as $property => $v) {
            $innerType = $schemas[$property]['type'];
            $results[$property] = $this->resolver->resolve($innerType)->convert($v, $innerType);
        }

        return $this->reflectionHydrator->hydrate($results, $refClass->newInstanceWithoutConstructor());
    }

    public function supports(string $type): bool
    {
        try {
            return (new \ReflectionClass($type))->isUserDefined();
        } catch (\ReflectionException $e) {
            return false;
        }
    }
}
