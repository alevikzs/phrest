<?php

namespace PhRest;

use \JsonSerializable,

    \PhMap\MapperTrait;

/**
 * Class Json
 * @package PhRest
 */
abstract class Json implements JsonSerializable {

    use TJsonSerializable;
    use MapperTrait;

}