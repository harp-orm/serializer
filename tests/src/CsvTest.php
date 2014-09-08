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
        return [
            [null, null],
            ['test', 'test'],
            [['test'], 'test'],
            [['test', 'test2'], 'test,test2'],
            [['test' => 'asd', 'test2' => 'asd2'], 'asd,asd2'],
        ];
    }

    /**
     * @covers ::serializeProperty
     * @dataProvider dataSerialize
     */
    public function testSerialze($value, $expected)
    {
        $serializer = new Csv('test');

        $subject = ['test' => $value];

        $this->assertEquals($expected, $serializer->serializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->serializeProperty($subject));
    }

    public function dataUnserialize()
    {
        return [
            ['test', ['test']],
            ['test,test2', ['test', 'test2']],
        ];
    }

    /**
     * @covers ::unserializeProperty
     * @dataProvider dataUnserialize
     */
    public function testUnserialze($value, $expected)
    {
        $serializer = new Csv('test');

        $subject = ['test' => $value];

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));
    }
}
