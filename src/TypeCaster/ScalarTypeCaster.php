<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use function Helicon\ObjectTypeParser\is_scalar_type_name;

final class ScalarTypeCaster implements TypeCasterInterface
{
    public function convert(mixed $value, string $type): mixed
    {
        settype($value, $type);

        return $value;
    }

    public function supports(string $type): bool
    {
        return is_scalar_type_name($type);
    }
}
