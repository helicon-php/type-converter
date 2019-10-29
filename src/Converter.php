<?php

declare(strict_types=1);

namespace Helicon\TypeConverter;

class Converter implements ConverterInterface
{
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @param Resolver $resolver
     */
    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke(array $row, array $schemas): array
    {
        $results = [];
        foreach ($row as $property => $value) {
            $schema = $schemas[$property];
            $typeCaster = $this->resolver->resolve($schema['type']);
            $results[$property] = $typeCaster->convert($value, $schema['type']);
        }

        return $results;
    }
}
