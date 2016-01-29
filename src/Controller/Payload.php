<?php

namespace PhRest\Controller;

use \Phalcon\Http\Response,

    \PhRest\ResponsePayload,
    \PhRest\Http\Response as HttpResponse;

/**
 * Class Payload
 * @package PhRest\Controller
 */
abstract class Payload extends Simple {

    use TPayload;

}