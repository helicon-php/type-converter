<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

interface TypeCasterInterface
{
    /**
     * @param $value
     *
     * @return mixed
     */
    public function convert($value, string $type);

    public function supports(string $type): bool;
}
