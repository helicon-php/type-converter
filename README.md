## helicon/type-converter
This library is convert array data to definition types.

## using

```shell script
$ composer req helicon/type-converter
```

```php
<?php

use Helicon\ObjectTypeParser\Parser;
use Helicon\TypeConverter\Resolver;
use Helicon\TypeConverter\Converter;
use Helicon\TypeConverter\TypeCaster\ClassTypeCaster;
use Helicon\TypeConverter\TypeCaster\DateTimeCaster;
use Helicon\TypeConverter\TypeCaster\ScalarTypeCaster;
use Laminas\Hydrator\ReflectionHydrator;



$hydrator = new ReflectionHydrator();
$resolver = new Resolver();
$parser = new Parser();

$resolver->addTypeCaster(new ScalarTypeCaster());
$resolver->addTypeCaster(new DateTimeCaster());
$resolver->addTypeCaster(new ClassTypeCaster($resolver, $parser, $hydrator));


$converter = new Converter($resolver);

$row = [
    'age' => '11',
    'year' => '3',
    'enable' => '0',
    'createdAt' => '2019-10-29 11:00:00',
    'friend' => [
        'id' => '21',
        'name' => 'taro yamda',
    ],
];

$schemas = [
    'age' => [
        'type' => 'integer',
    ],
    'year' => [
        'type' => 'int',
    ],
    'enable' => [
        'type' => 'bool',
    ],
    'createdAt' => [
        'type' => \DateTime::class,
    ],
    'friend' => [
        'type' => Friend::class,
    ],
];


$convertedRows = ($converter)($row, $schemas);
var_dump($convertedRows);
