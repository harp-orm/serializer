Serializer
==========

[![Build Status](https://travis-ci.org/harp-orm/serializer.png?branch=master)](https://travis-ci.org/harp-orm/serializer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harp-orm/serializer/badges/quality-score.png)](https://scrutinizer-ci.com/g/harp-orm/serializer/)
[![Code Coverage](https://scrutinizer-ci.com/g/harp-orm/serializer/badges/coverage.png)](https://scrutinizer-ci.com/g/harp-orm/serializer/)
[![Latest Stable Version](https://poser.pugx.org/harp-orm/serializer/v/stable.png)](https://packagist.org/packages/harp-orm/serializer)

Serialize object/array properties, using different rules for each property

Usage
-----

```php
use Harp\Serializer;

$serializers = new Serializer\Serializers([
    new Serializer\Native('nativeSerializerdArray'),
    new Serializer\Csv('csvString'),
    new Serializer\Json('jsonProperty'),
]);

$obj = new stdClass();

$obj->nativeSerializerdArray = array('test' => 'param');
$obj->csvString = array('val', 'val2');
$obj->jsonProperty = array('test' => 'asd');

$serialized = $serializers->serialize($obj);

print_r($serialized);

// Will output:
// stdClass Object
// (
//     [nativeSerializerdArray] => a:1:{s:4:"test";s:5:"param";}
//     [csvString] => val,val2
//     [jsonProperty] => {"test":"asd"}
// )

$result = $serializers->unserialize($serialized);

// Will be equal
$result == $obj;
```

License
-------

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
