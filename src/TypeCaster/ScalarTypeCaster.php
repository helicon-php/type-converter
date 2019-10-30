<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

use function Helicon\ObjectTypeParser\is_scalar_type_name;

class ScalarTypeCaster implements TypeCasterInterface
{
    /**
     * {@inheritdoc}
     */
    public function convert($value, string $type)
    {
        settype($value, $type);

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $type): bool
    {
        return is_scalar_type_name($type);
    }
}
