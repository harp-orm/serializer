<?php

namespace Harp\Serializer\Test;

use Harp\Serializer\NullSerializer;
use Harp\Serializer\Serializers;
use Harp\Serializer\Native;
use Harp\Serializer\Csv;
use stdClass;

/**
 * @coversDefaultClass Harp\Serializer\Serializers
 */
class SerializersTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::all
     * @covers ::add
     * @covers ::set
     * @covers ::next
     * @covers ::current
     * @covers ::valid
     * @covers ::count
     * @covers ::key
     * @covers ::rewind
     * @covers ::contains
     * @covers ::isEmpty
     */
    public function testConstruct()
    {
        $serializerObjects = [
            new NullSerializer('test'),
            new NullSerializer('test2'),
        ];

        $serializers = new Serializers($serializerObjects);

        $this->assertCount(2, $serializers);
        $this->assertFalse($serializers->isEmpty());

        $this->assertEquals($serializers->key(), $serializers->all()->key());

        foreach ($serializers as $serializer)
        {
            $this->assertContains($serializer, $serializerObjects);
            $this->assertTrue($serializers->contains($serializer));
        }

        $serializers->rewind();

        $this->assertFalse($serializers->isEmpty());

        $all = $serializers->all();

        $this->assertCount(2, $all);

        foreach ($all as $serializer)
        {
            $this->assertContains($serializer, $serializerObjects);
            $this->assertTrue($all->contains($serializer));
        }

        $csv = new Csv('test3');

        $serializers->add($csv);
        $this->assertCount(3, $serializers);
        $this->assertTrue($serializers->contains($csv));
    }

    public function dataSerialize()
    {
        $serializers = new Serializers([
            new Native('test'),
            new Csv('test2'),
        ]);

        return [
            [
                (object) [
                    'test' => ['test' => 'param'],
                    'test2' => ['val1', 'val2']
                ],
                $serializers,
                (object) [
                    'test' => 'a:1:{s:4:"test";s:5:"param";}',
                    'test2' => 'val1,val2',
                ],
            ],
            [
                [
                    'test' => ['test' => 'param'],
                    'test2' => ['val1', 'val2']
                ],
                $serializers,
                [
                    'test' => 'a:1:{s:4:"test";s:5:"param";}',
                    'test2' => 'val1,val2',
                ],
            ]
        ];
    }

    /**
     * @covers ::serialize
     * @dataProvider dataSerialize
     */
    public function testSerialize($subject, $serializers, $expected)
    {
        $serialized = $serializers->serialize($subject);

        $this->assertEquals($expected, $serialized);
        $this->assertEquals($expected, $subject);

        $this->setExpectedException('InvalidArgumentException', 'Subject must be either array or object');

        $var = 'asd';

        $serializers->serialize($var);
    }

    public function dataUnserialize()
    {
        $serializers = new Serializers([
            new Native('test'),
            new Csv('test2'),
        ]);

        return [
            [
                (object) [
                    'test' => 'a:1:{s:4:"test";s:5:"param";}',
                    'test2' => 'val1,val2',
                ],
                $serializers,
                (object) [
                    'test' => ['test' => 'param'],
                    'test2' => ['val1', 'val2']
                ],
            ],
            [
                [
                    'test' => 'a:1:{s:4:"test";s:5:"param";}',
                    'test2' => 'val1,val2',
                ],
                $serializers,
                [
                    'test' => ['test' => 'param'],
                    'test2' => ['val1', 'val2']
                ],
            ]
        ];
    }

    /**
     * @covers ::unserialize
     * @dataProvider dataUnserialize
     */
    public function testUnserialize($subject, $serializers, $expected)
    {
        $unserialized = $serializers->unserialize($subject);

        $this->assertEquals($expected, $unserialized);
        $this->assertEquals($expected, $subject);

        $this->setExpectedException('InvalidArgumentException', 'Subject must be either array or object');

        $var = 'asd';

        $serializers->unserialize($var);

    }
}
