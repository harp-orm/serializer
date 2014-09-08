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
        return [
            [null, 'null'],
            ['test', '"test"'],
            [true, 'true'],
            [false, 'false'],
            [['test' => 'asd'], '{"test":"asd"}'],
            [new SerializableObject('tmp'), '{"prop":"tmp"}'],
        ];
    }

    /**
     * @covers ::serializeProperty
     * @dataProvider dataSerialize
     */
    public function testSerialze($value, $expected)
    {
        $serializer = new Json('test');

        $subject = ['test' => $value];

        $this->assertEquals($expected, $serializer->serializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->serializeProperty($subject));
    }

    public function dataUnserialize()
    {
        return [
            ['null', null, null],
            ['"test"', 'test', null],
            ['true', true, null],
            ['false', false, null],
            ['{"test":"asd"}', ['test' => 'asd'], null],
            ['{"test":}', null, 'Error parsing JSON property: Syntax error, malformed JSON'],
        ];
    }

    /**
     * @covers ::unserializeProperty
     * @dataProvider dataUnserialize
     */
    public function testUnserialze($value, $expected, $exception)
    {
        $serializer = new Json('test');

        $subject = ['test' => $value];

        if ($exception) {
            $this->setExpectedException('InvalidArgumentException', $exception);
        }

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));
    }
}
