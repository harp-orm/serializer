<?php

namespace Harp\Serializer;

use InvalidArgumentException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Json extends AbstractSerializer
{
    public static $errors = array(
        JSON_ERROR_DEPTH            => 'Maximum stack depth exceeded',
        JSON_ERROR_STATE_MISMATCH   => 'Underflow or the modes mismatch',
        JSON_ERROR_CTRL_CHAR        => 'Unexpected control character found',
        JSON_ERROR_SYNTAX           => 'Syntax error, malformed JSON',
        JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded'
    );

    /**
     * @param  object|array $subject
     * @return mixed
     */
    public function serializeProperty($subject)
    {
        return json_encode($this->getProperty($subject));
    }

    /**
     * @param  object|array $subject
     * @return mixed
     */
    public function unserializeProperty($subject)
    {
        $data = json_decode($this->getProperty($subject), true);

        if ($data === null AND json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(
                sprintf('Error parsing JSON property: %s', self::$errors[json_last_error()])
            );
        }

        return $data;
    }
}
