<?php

namespace Harp\Serializer\Test;

use Harp\Serializer\NullSerializer;
use stdClass;

/**
 * @coversDefaultClass Harp\Serializer\AbstractSerializer
 */
class AbstractSerializerTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getName
     */
    public function testConstruct()
    {
        $item = new NullSerializer('test');

        $this->assertSame('test', $item->getName());
    }

    public function dataIssetProperty()
    {
        return array(
            array(array('test' => null), 'test', false, null),
            array(array('test' => 'param'), 'test', true, null),
            array(new SerializableObject('tmp'), 'test', false, null),
            array(new SerializableObject('tmp'), 'prop', true, null),
            array('wrong type', 'prop', false, 'Subject must be either array or object'),
        );
    }

    /**
     * @covers ::issetProperty
     * @dataProvider dataIssetProperty
     */
    public function testIssertProperty($subject, $name, $expected, $expectedException)
    {
        $item = new NullSerializer($name);

        if ($expectedException) {
            $this->setExpectedException('InvalidArgumentException', $expectedException);
        }

        $this->assertSame($expected, $item->issetProperty($subject));
    }

    public function dataGetProperty()
    {
        return array(
            array(array('test' => null), 'test', null, null),
            array(array('test' => 'param'), 'test', 'param', null),
            array(new SerializableObject('tmp'), 'prop', 'tmp', null),
            array('wrong type', 'prop', null, 'Subject must be either array or object'),
        );
    }

    /**
     * @covers ::getProperty
     * @dataProvider dataGetProperty
     */
    public function testGetProperty($subject, $name, $expected, $expectedException)
    {
        $item = new NullSerializer($name);

        if ($expectedException) {
            $this->setExpectedException('InvalidArgumentException', $expectedException);
        }

        $this->assertSame($expected, $item->getProperty($subject));
    }

    public function dataSetProperty()
    {
        return array(
            array(array('test' => null), 'test', 'val', array('test' => 'val'), null),
            array(array('test' => 'param'), 'test', 'val', array('test' => 'val'), null),
            array(new SerializableObject('tmp'), 'prop', 'test', new SerializableObject('test'), null),
            array(new SerializableObject(), 'prop', 'test', new SerializableObject('test'), null),
            array('wrong type', 'prop', null, null, 'Subject must be either array or object'),
        );
    }

    /**
     * @covers ::setProperty
     * @dataProvider dataSetProperty
     */
    public function testSetProperty($subject, $name, $val, $expected, $expectedException)
    {
        $item = new NullSerializer($name);

        if ($expectedException) {
            $this->setExpectedException('InvalidArgumentException', $expectedException);
        }

        $item->setProperty($subject, $val);

        $this->assertEquals($expected, $subject);
    }

    public function dataSerialize()
    {
        return array(
            array(array('test' => 'tmp')),
            array(new SerializableObject('tmp')),
        );
    }

    /**
     * @covers ::serialize
     * @dataProvider dataSerialize
     */
    public function testSerializeArray($subject)
    {
        $subject = array('test' => 'tmp');

        $item = $this->getMock(
            'Harp\Serializer\NullSerializer',
            array('issetProperty', 'setProperty', 'serializeProperty'),
            array('test')
        );

        $item
            ->expects($this->exactly(2))
            ->method('issetProperty')
            ->with($this->identicalTo($subject))
            ->will($this->onConsecutiveCalls(false, true));

        $item
            ->expects($this->once())
            ->method('setProperty')
            ->with($this->identicalTo($subject), $this->equalTo('test2'));

        $item
            ->expects($this->once())
            ->method('serializeProperty')
            ->with($this->identicalTo($subject))
            ->will($this->returnValue('test2'));

        $item
            ->serialize($subject)
            ->serialize($subject);
    }

    public function dataUnserialize()
    {
        return array(
            array(array('test' => 'tmp')),
            array(new SerializableObject('tmp')),
        );
    }

    /**
     * @covers ::unserialize
     * @dataProvider dataUnserialize
     */
    public function testUnserializeArray($subject)
    {
        $subject = array('test' => 'tmp');

        $item = $this->getMock(
            'Harp\Serializer\NullSerializer',
            array('issetProperty', 'setProperty', 'unserializeProperty'),
            array('test')
        );

        $item
            ->expects($this->exactly(2))
            ->method('issetProperty')
            ->with($this->identicalTo($subject))
            ->will($this->onConsecutiveCalls(false, true));

        $item
            ->expects($this->once())
            ->method('setProperty')
            ->with($this->identicalTo($subject), $this->equalTo('test2'));

        $item
            ->expects($this->once())
            ->method('unserializeProperty')
            ->with($this->identicalTo($subject))
            ->will($this->returnValue('test2'));

        $item
            ->unserialize($subject)
            ->unserialize($subject);
    }
}
