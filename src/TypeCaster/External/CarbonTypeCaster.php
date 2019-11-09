<?php

namespace Helicon\TypeConverter\TypeCaster\External;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Helicon\TypeConverter\TypeCaster\TypeCasterInterface;

class CarbonTypeCaster implements TypeCasterInterface
{
    public function convert($value, string $type)
    {
        return new $type($value);
    }

    public function supports(string $type): bool
    {
        return Carbon::class === $type || CarbonImmutable::class === $type;
    }
}
