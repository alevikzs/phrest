<?php

namespace PhRest\Exception;

use \ErrorException,
    \JsonSerializable;

/**
 * Class Error
 * @package PhRest\Exception
 */
class Error extends ErrorException implements JsonSerializable {

    /**
     * @return array
     */
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        unset($vars['xdebug_message']);

        return $vars;
    }

}