<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

class ScalarTypeCaster implements TypeCasterInterface
{
    private const SUPPORTED_TYPES = [
        'boolean',
        'bool',
        'integer',
        'int',
        'string',
        'float',
        'double',
    ];

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
        return \in_array($type, self::SUPPORTED_TYPES, true);
    }
}
