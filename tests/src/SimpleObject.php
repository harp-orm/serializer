<?php

namespace Harp\Serializer\Test;

use Serializable;

class SimpleObject implements Serializable
{
    public $prop1;
    public $prop2;

    public function __construct($prop1 = null, $prop2 = null)
    {
        $this->prop1 = $prop1;
        $this->prop2 = $prop2;
    }

    public function serialize()
    {
        return $this->prop1.','.$this->prop2;
    }

    public function unserialize($data)
    {
        list($this->prop1, $this->prop2) = explode(',', $data);
    }
}
