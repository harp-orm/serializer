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
        return array(
            array(null, serialize(null)),
            array('test', serialize('test')),
            array(true, serialize(true)),
            array(false, serialize(false)),
            array(array('test' => 'asd'), serialize(array('test' => 'asd'))),
            array(new SerializableObject('tmp'), serialize(new SerializableObject('tmp'))),
        );
    }

    /**
     * @covers ::serializeProperty
     * @dataProvider dataSerialize
     */
    public function testSerialze($value, $expected)
    {
        $serializer = new Native('test');

        $subject = array('test' => $value);

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

        $subject = array('test' => $value);

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));
    }
}
