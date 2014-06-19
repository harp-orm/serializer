<?php

namespace Harp\Serializer;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Csv extends AbstractSerializer
{
    /**
     * @param  object|array $subject
     * @return mixed
     */
    public function serializeProperty($subject)
    {
        return implode(',', (array) $this->getProperty($subject));
    }

    /**
     * @param  object|array $subject
     * @return mixed
     */
    public function unserializeProperty($subject)
    {
        return explode(',', $this->getProperty($subject));
    }
}
