<?php

namespace Harp\Serializer;

use InvalidArgumentException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
abstract class AbstractSerializer
{
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  object|array $subject
     * @return boolean
     * @throws InvalidArgumentException If subject not array or object
     */
    public function issetProperty($subject)
    {
        if (is_array($subject)) {
            return isset($subject[$this->name]);
        } elseif (is_object($subject)) {
            return isset($subject->{$this->name});
        } else {
            throw new InvalidArgumentException('Subject must be either array or object');
        }
    }

    /**
     * @param  object|array $subject
     * @return  mixed
     * @throws InvalidArgumentException If subject not array or object
     */
    public function getProperty($subject)
    {
        if (is_array($subject)) {
            return $subject[$this->name];
        } elseif (is_object($subject)) {
            return $subject->{$this->name};
        } else {
            throw new InvalidArgumentException('Subject must be either array or object');
        }
    }

    /**
     * @param  object|array $subject
     * @param  mixed        $value
     * @throws InvalidArgumentException If subject not array or object
     */
    public function setProperty(& $subject, $value)
    {
        if (is_array($subject)) {
            return $subject[$this->name] = $value;
        } elseif (is_object($subject)) {
            return $subject->{$this->name} = $value;
        } else {
            throw new InvalidArgumentException('Subject must be either array or object');
        }
    }

    /**
     * @param  object|array $subject
     * @return AbstractSerializer $this
     */
    abstract public function serializeProperty($subject);

    /**
     * @param  object|array $subject
     * @return AbstractSerializer $this
     */
    abstract public function unserializeProperty($subject);

    /**
     * @param  object|array $subject
     * @return AbstractSerializer $this
     */
    public function serialize($subject)
    {
        if ($this->issetProperty($subject)) {
            $this->setProperty($subject, $this->serializeProperty($subject));
        }

        return $this;
    }

    /**
     * @param  object|array $subject
     * @return AbstractSerializer $this
     */
    public function unserialize($subject)
    {
        if ($this->issetProperty($subject)) {
            $this->setProperty($subject, $this->unserializeProperty($subject));
        }

        return $this;
    }
}
