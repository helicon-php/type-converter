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
        $type = str_replace("\\", '', $type);
        return \DateTime::class === $type || \DateTimeImmutable::class === $type;
    }
}
