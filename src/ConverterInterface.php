<?php

declare(strict_types=1);

namespace Helicon\TypeConverter;

interface ConverterInterface
{
    public function __invoke(array $row, array $schemas): array;
}
