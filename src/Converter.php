<?php

declare(strict_types=1);

namespace Helicon\TypeConverter;

class Converter implements ConverterInterface
{
    public function __construct(private Resolver $resolver)
    {
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
