<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use Helicon\TypeConverter\Exception\TypeCasterException;

class NumberTypeCaster implements TypeCasterInterface
{
    public function convert($value, string $type)
    {
        if (\is_int($value) || \is_float($value)) {
            return $value;
        }

        if (preg_match('/^(\d+)$/', $value, $matches)) {
            return (int) $value;
        }

        if (preg_match('/^(\d+\.\d+)$/', $value, $matches)) {
            return (float) $value;
        }

        throw new TypeCasterException('Is not number type '.$value);
    }

    public function supports(string $type): bool
    {
        return 'number' === $type;
    }
}
