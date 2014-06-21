Serializer
==========

[![Build Status](https://travis-ci.org/harp-orm/serializer.png?branch=master)](https://travis-ci.org/harp-orm/serializer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harp-orm/serializer/badges/quality-score.png)](https://scrutinizer-ci.com/g/harp-orm/serializer/)
[![Code Coverage](https://scrutinizer-ci.com/g/harp-orm/serializer/badges/coverage.png)](https://scrutinizer-ci.com/g/harp-orm/serializer/)
[![Latest Stable Version](https://poser.pugx.org/harp-orm/serializer/v/stable.png)](https://packagist.org/packages/harp-orm/serializer)

Serialize object/array properties, using different rules for each property.

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

$serializers->serialize($obj);

// Will output:
// stdClass Object
// (
//     [nativeSerializerdArray] => a:1:{s:4:"test";s:5:"param";}
//     [csvString] => val,val2
//     [jsonProperty] => {"test":"asd"}
// )
print_r($obj);

// Will unserialize all the relevant properties
$serializers->unserialize($obj);
```

Harp ORM Integration
--------------------

Serializer is integrated into Harp ORM and gives you the ability to store arbitrary data in your database, by serializing the model's properties.

For example holding an api response in a "response" field.

```php
// Model
class Payment extends AbstractModel
{
    public $id;
    public $response;
}

// Repo
class Payment extends AbstractRepo
{
    public function initialize()
    {
        $this
            ->addSerializers([
                new Serializer\Json('response'),
            ]);
    }
}

$model = new Model\Payment(['response' => $someArray]);

// The response property will get serialized as a json string.
Repo\Payment::get()->save($model);
```

License
-------

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
