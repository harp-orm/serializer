<?php

namespace Harp\Serializer;

use Closure;

/**
 * Add this trait to your object to make properties "serializable"
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
trait SerializersTrait
{
    /**
     * @var Serializers
     */
    private $serializers;

    /**
     * Get Serializers
     *
     * @return Serializers
     */
    public function getSerializers()
    {
        if (! $this->serializers) {
            $this->serializers = new Serializers();
        }

        return $this->serializers;
    }

    /**
     * @return self
     */
    public function addSerializer(AbstractSerializer $serializer)
    {
        $this->getSerializers()->add($serializer);

        return $this;
    }

    /**
     * @param  string $name
     * @return self
     */
    public function serializeCsv($name)
    {
        return $this->addSerializer(new Csv($name));
    }

    /**
     * @param  string $name
     * @return self
     */
    public function serializeJson($name)
    {
        return $this->addSerializer(new Json($name));
    }

    /**
     * @param  string $name
     * @return self
     */
    public function serializeNative($name)
    {
        return $this->addSerializer(new Native($name));
    }

    /**
     * @param  string $name
     * @param  string $class
     * @return self
     */
    public function serializeObject($name, $class)
    {
        return $this->addSerializer(new Object($name, $class));
    }

}
