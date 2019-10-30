<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use Helicon\ObjectTypeParser\Parser;
use Helicon\TypeConverter\Exception\TypeCasterException;
use Helicon\TypeConverter\Resolver;
use Zend\Hydrator\ReflectionHydrator;

class ClassTypeCaster implements TypeCasterInterface
{
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var ReflectionHydrator
     */
    private $reflectionHydrator;

    /**
     * @param Resolver           $resolver
     * @param Parser             $parser
     * @param ReflectionHydrator $reflectionHydrator
     */
    public function __construct(Resolver $resolver, Parser $parser, ReflectionHydrator $reflectionHydrator)
    {
        $this->resolver = $resolver;
        $this->parser = $parser;
        $this->reflectionHydrator = $reflectionHydrator;
    }

    /**
     * @param $value
     * @param string $type
     *
     * @return mixed|object
     *
     * @throws \ReflectionException
     */
    public function convert($value, string $type)
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
            $refClass = new \ReflectionClass($type);

            return $refClass->isUserDefined();
        } catch (\ReflectionException $e) {
            return false;
        }
    }
}
