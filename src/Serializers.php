<?php

namespace Harp\Serializer;

use Countable;
use Iterator;
use SplObjectStorage;
use InvalidArgumentException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Serializers implements Iterator, Countable
{
    private $serializers;

    public function __construct(array $serializers = array())
    {
        $this->serializers = new SplObjectStorage();

        $this->set($serializers);
    }

    /**
     * @return AbstractSerializer
     */
    public function current()
    {
        return $this->serializers->current();
    }

    /**
     * @return integer
     */
    public function key()
    {
        return $this->serializers->key();
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->serializers->next();
    }

    /**
     * @return void
     */
    public function rewind()
    {
        return $this->serializers->rewind();
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return $this->serializers->valid();
    }

    /**
     * @param AbstractSerializer $serializer
     */
    public function add(AbstractSerializer $serializer)
    {
        $this->serializers->attach($serializer);
    }

    /**
     * @return boolean
     */
    public function isEmpty()
    {
        return count($this->serializers) === 0;
    }

    /**
     * @param array $serializers
     */
    public function set(array $serializers)
    {
        array_walk($serializers, array($this, 'add'));

        return $this;
    }

    /**
     * @param  AbstractSerializer $serializer
     * @return boolean
     */
    public function contains(AbstractSerializer $serializer)
    {
        return $this->serializers->contains($serializer);
    }

    /**
     * @return integer
     */
    public function count()
    {
        return $this->serializers->count();
    }

    /**
     * @return SplObjectStorage
     */
    public function all()
    {
        return $this->serializers;
    }

    /**
     * @param  object|array $subject
     * @return object|array
     * @throws InvalidArgumentException If subject not array or object
     */
    public function serialize($subject)
    {
        if (is_object($subject)) {
            $subject = clone $subject;
        } elseif (! is_array($subject)) {
            throw new InvalidArgumentException('Subject must be either array or object');
        }

        foreach ($this->serializers as $serializer) {
            $serializer->serialize($subject);
        }

        return $subject;
    }

    /**
     * @param  object|array $subject
     * @return object|array
     * @throws InvalidArgumentException If subject not array or object
     */
    public function unserialize($subject)
    {
        if (is_object($subject)) {
            $subject = clone $subject;
        } elseif (! is_array($subject)) {
            throw new InvalidArgumentException('Subject must be either array or object');
        }

        foreach ($this->serializers as $serializer) {
            $serializer->unserialize($subject);
        }

        return $subject;
    }
}
