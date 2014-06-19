<?php

namespace Harp\Serializer\Test;

use Harp\Serializer\NullSerializer;
use stdClass;

/**
 * @coversDefaultClass Harp\Serializer\NullSerializer
 */
class NullSerializerTest extends AbstractTestCase
{
    public function dataSerialize()
    {
        return array(
            array(null, null),
            array('test', 'test'),
            array(true, true),
            array(false, false),
            array(array('test' => 'asd'), array('test' => 'asd')),
            array(new SerializableObject('tmp'), new SerializableObject('tmp')),
        );
    }

    /**
     * @covers ::serializeProperty
     * @dataProvider dataSerialize
     */
    public function testSerialze($value, $expected)
    {
        $serializer = new NullSerializer('test');

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
        $serializer = new NullSerializer('test');

        $subject = array('test' => $value);

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));
    }
}
