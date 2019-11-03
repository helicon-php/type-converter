<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

class DateTimeCaster implements TypeCasterInterface
{
    public function convert($value, string $type)
    {
        return new $type($value);
    }

    public function supports(string $type): bool
    {
        if (!class_exists($type)) {
            return false;
        }

        return (new \ReflectionClass($type))->implementsInterface(\DateTimeInterface::class);
    }
}
