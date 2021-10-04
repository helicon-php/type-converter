<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

interface TypeCasterInterface
{
    public function convert(mixed $value, string $type): mixed;

    public function supports(string $type): bool;
}
