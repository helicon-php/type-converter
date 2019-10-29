<?php

declare(strict_types=1);

namespace Helicon\TypeConverter;

use Helicon\TypeConverter\Exception\TypeCasterException;
use Helicon\TypeConverter\TypeCaster\TypeCasterInterface;

class Resolver
{
    /**
     * @var TypeCasterInterface[]
     */
    private $typeCasters = [];

    public function addConverter(TypeCasterInterface $typeCaster): void
    {
        $this->typeCasters[] = $typeCaster;
    }

    public function resolve(string $type): TypeCasterInterface
    {
        foreach ($this->typeCasters as $typeCaster) {
            if ($typeCaster->supports($type)) {
                return $typeCaster;
            }
        }
        throw new TypeCasterException('converter not supported '.$type); // TODO custom exception.
    }
}
