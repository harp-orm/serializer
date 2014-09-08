<?php

namespace Harp\Serializer\Test;

use Harp\Serializer\Native;
use stdClass;

/**
 * @coversDefaultClass Harp\Serializer\Native
 */
class NativeTest extends AbstractTestCase
{
    public function dataSerialize()
    {
        return [
            [null, serialize(null)],
            ['test', serialize('test')],
            [true, serialize(true)],
            [false, serialize(false)],
            [['test' => 'asd'], serialize(['test' => 'asd'])],
            [new SerializableObject('tmp'), serialize(new SerializableObject('tmp'))],
        ];
    }

    /**
     * @covers ::serializeProperty
     * @dataProvider dataSerialize
     */
    public function testSerialze($value, $expected)
    {
        $serializer = new Native('test');

        $subject = ['test' => $value];

        $this->assertEquals($expected, $serializer->serializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->serializeProperty($subject));
    }

    /**
     * @covers ::unserializeProperty
     * @dataProvider dataSerialize
     */
    public function testUnserialze($expected, $value)
    {
        $serializer = new Native('test');

        $subject = ['test' => $value];

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));
    }
}
