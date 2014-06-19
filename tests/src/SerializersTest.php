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
        $serializerObjects = array(
            new NullSerializer('test'),
            new NullSerializer('test2'),
        );

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

    /**
     * @covers ::serialize
     */
    public function testSerialize()
    {
        $subject = new stdClass();

        $subject->test = array('test' => 'param');
        $subject->test2 = array('val1', 'val2');

        $serializers = new Serializers(array(
            new Native('test'),
            new Csv('test2'),
        ));

        $serialized = $serializers->serialize($subject);

        $expected = new stdClass();

        $expected->test = 'a:1:{s:4:"test";s:5:"param";}';
        $expected->test2 = 'val1,val2';

        $this->assertNotSame($subject, $serialized);
        $this->assertEquals($expected, $serialized);

        $this->setExpectedException('InvalidArgumentException', 'Subject must be either array or object');

        $serializers->serialize('wrong argument');
    }

    /**
     * @covers ::unserialize
     */
    public function testUnserialize()
    {
        $subject = new stdClass();

        $subject->test = 'a:1:{s:4:"test";s:5:"param";}';
        $subject->test2 = 'val1,val2';

        $serializers = new Serializers(array(
            new Native('test'),
            new Csv('test2'),
        ));

        $serialized = $serializers->unserialize($subject);

        $expected = new stdClass();

        $expected->test = array('test' => 'param');
        $expected->test2 = array('val1', 'val2');

        $this->assertNotSame($subject, $serialized);
        $this->assertEquals($expected, $serialized);

        $this->setExpectedException('InvalidArgumentException', 'Subject must be either array or object');

        $serializers->unserialize('wrong argument');

    }
}
