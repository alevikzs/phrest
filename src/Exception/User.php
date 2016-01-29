<?php

namespace PhRest\Exception;

use \JsonSerializable,

    \Phalcon\Exception as PhalconException;

/**
 * Class User
 * @package PhRest\Exception
 */
class User extends PhalconException implements JsonSerializable {

    /**
     * @return array
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        unset($vars['xdebug_message']);

        return $vars;
    }

}