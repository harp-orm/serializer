<?php

namespace Harp\Serializer\Test;

use Serializable;

class SerializableObject implements Serializable
{
    public $prop;

    public function __construct($prop = null)
    {
        $this->prop = $prop;
    }

    public function getProp()
    {
        return $prop;
    }

    public function setProp($value)
    {
        $this->prop = $value;

        return $this;
    }

    public function serialize()
    {
        return serialize($this->prop);
    }

    public function unserialize($data)
    {
        $this->prop = unserialize($data);
    }
}
