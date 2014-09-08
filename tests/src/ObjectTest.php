<?php

namespace Harp\Serializer\Test;

use Harp\Serializer\Object;
use stdClass;

/**
 * @coversDefaultClass Harp\Serializer\Object
 */
class ObjectTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getClass
     * @covers ::newInstance
     */
    public function testConstruct()
    {
        $object = new Object('test', 'stdClass');
        $this->assertEquals($object->getClass(), 'stdClass');
        $this->assertInstanceOf('stdClass', $object->newInstance());
    }

    public function dataSerialize()
    {
        return array(
            array(new SimpleObject(1, 10), '1,10'),
            array(new SimpleObject(), ','),
            array(new SimpleObject(2), '2,'),
            array(new SimpleObject(null, 32), ',32'),
        );
    }

    public function dataUnserialize()
    {
        return array(
            array(new SimpleObject(1, 10), '1,10'),
            array(new SimpleObject(), null),
            array(new SimpleObject(), ''),
            array(new SimpleObject(null, 32), ',32'),
        );
    }

    /**
     * @covers ::serializeProperty
     * @dataProvider dataSerialize
     */
    public function testSerialze($value, $expected)
    {
        $serializer = new Object('test', 'Harp\Serializer\Test\SimpleObject');

        $subject = array('test' => $value);

        $this->assertEquals($expected, $serializer->serializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->serializeProperty($subject));
    }

    /**
     * @covers ::unserializeProperty
     * @dataProvider dataUnserialize
     */
    public function testUnserialze($expected, $value)
    {
        $serializer = new Object('test', 'Harp\Serializer\Test\SimpleObject');

        $subject = array('test' => $value);

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));
    }
}
