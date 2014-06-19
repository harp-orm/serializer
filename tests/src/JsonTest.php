<?php

namespace Harp\Serializer\Test;

use Harp\Serializer\Json;
use stdClass;

/**
 * @coversDefaultClass Harp\Serializer\Json
 */
class JsonTest extends AbstractTestCase
{
    public function dataSerialize()
    {
        return array(
            array(null, 'null'),
            array('test', '"test"'),
            array(true, 'true'),
            array(false, 'false'),
            array(array('test' => 'asd'), '{"test":"asd"}'),
            array(new SerializableObject('tmp'), '{"prop":"tmp"}'),
        );
    }

    /**
     * @covers ::serializeProperty
     * @dataProvider dataSerialize
     */
    public function testSerialze($value, $expected)
    {
        $serializer = new Json('test');

        $subject = array('test' => $value);

        $this->assertEquals($expected, $serializer->serializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->serializeProperty($subject));
    }

    public function dataUnserialize()
    {
        return array(
            array('null', null, null),
            array('"test"', 'test', null),
            array('true', true, null),
            array('false', false, null),
            array('{"test":"asd"}', array('test' => 'asd'), null),
            array('{"test":}', null, 'Error parsing JSON property: Syntax error, malformed JSON'),
        );
    }

    /**
     * @covers ::unserializeProperty
     * @dataProvider dataUnserialize
     */
    public function testUnserialze($value, $expected, $exception)
    {
        $serializer = new Json('test');

        $subject = array('test' => $value);

        if ($exception) {
            $this->setExpectedException('InvalidArgumentException', $exception);
        }

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));
    }
}
