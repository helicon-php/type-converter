<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster\External;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Helicon\TypeConverter\TypeCaster\TypeCasterInterface;

class CarbonTypeCaster implements TypeCasterInterface
{
    public function convert(mixed $value, string $type): mixed
    {
        return new $type($value);
    }

    public function supports(string $type): bool
    {
        return Carbon::class === $type || CarbonImmutable::class === $type;
    }
}
