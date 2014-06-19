<?php

namespace Harp\Serializer\Test;

use Harp\Serializer\Csv;
use stdClass;

/**
 * @coversDefaultClass Harp\Serializer\Csv
 */
class CsvTest extends AbstractTestCase
{
    public function dataSerialize()
    {
        return array(
            array(null, null),
            array('test', 'test'),
            array(array('test'), 'test'),
            array(array('test', 'test2'), 'test,test2'),
            array(array('test' => 'asd', 'test2' => 'asd2'), 'asd,asd2'),
        );
    }

    /**
     * @covers ::serializeProperty
     * @dataProvider dataSerialize
     */
    public function testSerialze($value, $expected)
    {
        $serializer = new Csv('test');

        $subject = array('test' => $value);

        $this->assertEquals($expected, $serializer->serializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->serializeProperty($subject));
    }

    public function dataUnserialize()
    {
        return array(
            array('test', array('test')),
            array('test,test2', array('test', 'test2')),
        );
    }

    /**
     * @covers ::unserializeProperty
     * @dataProvider dataUnserialize
     */
    public function testUnserialze($value, $expected)
    {
        $serializer = new Csv('test');

        $subject = array('test' => $value);

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));
    }
}
