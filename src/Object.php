<?php

namespace Harp\Serializer;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Object extends AbstractSerializer
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param string $name
     */
    public function __construct($name, $class)
    {
        parent::__construct($name);

        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return object
     */
    public function newInstance()
    {
        $class = $this->class;

        return new $class();
    }

    /**
     * @param  object|array $subject
     * @return mixed
     */
    public function serializeProperty($subject)
    {
        $object = $this->getProperty($subject);

        return $object->serialize();
    }

    /**
     * @param  object|array $subject
     * @return mixed
     */
    public function unserializeProperty($subject)
    {
        $object = $this->newInstance();

        $data = $this->getProperty($subject);

        if ($data) {
            $object->unserialize($data);
        }

        return $object;
    }
}
