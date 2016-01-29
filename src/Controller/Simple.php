<?php

namespace PhRest\Controller;

use \Phalcon\Http\Response,

    \PhRest\Controller,
    \PhRest\ResponsePayload,
    \PhRest\Http\Response as HttpResponse;

/**
 * Class Simple
 * @package PhRest\Controller
 */
abstract class Simple extends Controller {

    /**
     * @param mixed $data
     * @return HttpResponse
     */
    public function response($data = null) {
        $response = new ResponsePayload($data);

        return (new HttpResponse($response));
    }

}