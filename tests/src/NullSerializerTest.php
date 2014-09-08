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
        return [
            [null, null],
            ['test', 'test'],
            [true, true],
            [false, false],
            [['test' => 'asd'], ['test' => 'asd']],
            [new SerializableObject('tmp'), new SerializableObject('tmp')],
        ];
    }

    /**
     * @covers ::serializeProperty
     * @dataProvider dataSerialize
     */
    public function testSerialze($value, $expected)
    {
        $serializer = new NullSerializer('test');

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
        $serializer = new NullSerializer('test');

        $subject = ['test' => $value];

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));

        $subject = new stdClass();
        $subject->test = $value;

        $this->assertEquals($expected, $serializer->unserializeProperty($subject));
    }
}
