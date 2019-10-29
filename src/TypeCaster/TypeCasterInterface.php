<?php

declare(strict_types=1);

namespace Helicon\TypeConverter\TypeCaster;

interface TypeCasterInterface
{
    /**
     * @param $value
     * @param string $type
     *
     * @return mixed
     */
    public function convert($value, string $type);

    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool;
}
