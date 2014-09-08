<?php

namespace Harp\Serializer\Test;

use Harp\Serializer\AbstractSerializer;
use Harp\Serializer\Csv;
use Harp\Serializer\Json;
use Harp\Serializer\Object;
use Harp\Serializer\Native;

/**
 * @coversDefaultClass Harp\Serializer\SerializersTrait
 */
class SerializersTraitTest extends AbstractTestCase
{
    /**
     * @covers ::getSerializers
     * @covers ::addSerializer
     */
    public function testConstruct()
    {
        $config = new TestConfig();

        $serializers = $config->getSerializers();

        $this->assertInstanceOf('Harp\Serializer\Serializers', $serializers);
        $this->assertCount(0, $serializers);

        $csv = new Csv('test');

        $config->addSerializer($csv);

        $this->assertCount(1, $config->getSerializers());

        $this->assertContains($csv, $config->getSerializers()->all());
    }

    public function dataShortcuts()
    {
        return [
            ['serializeCsv', ['test'], new Csv('test')],
            ['serializeJson', ['test'], new Json('test')],
            ['serializeNative', ['test'], new Native('test')],
            ['serializeObject', ['test', 'stdClass'], new Object('test', 'stdClass')],
        ];
    }

    /**
     * @dataProvider dataShortcuts
     * @covers ::serializeCsv
     * @covers ::serializeJson
     * @covers ::serializeNative
     * @covers ::serializeObject
     *
     * @param  string             $methodName
     * @param  array              $arguments
     * @param  AbstractSerializer $expected
     */
    public function testShortcuts($methodName, array $arguments, AbstractSerializer $expected)
    {
        $config = new TestConfig();

        $config = $this->getMock('Harp\Serializer\Test\TestConfig', ['addSerializer']);

        $config
            ->expects($this->once())
            ->method('addSerializer')
            ->with($this->equalTo($expected));

        call_user_func_array([$config, $methodName], $arguments);
    }
}
