<?php

namespace PhRest\Http\Response;

use \Exception,

    \PhRest\ResponsePayload\Exception as ResponsePayloadException,
    \PhRest\Http\Response;

/**
 * Class Error
 * @package PhRest\Http\Response
 */
class Error extends Response {

    const DEFAULT_STATUS_CODE = 500;

    /**
     * @param ResponsePayloadException $body
     */
    public function __construct(ResponsePayloadException $body) {
        parent::__construct(
            $body,
            $this->getStatusCodeFromException($body->getException())
        );
    }

    /**
     * @param Exception $exception
     * @return integer
     */
    protected function getStatusCodeFromException(Exception $exception) {
        return $this->isStandardCode($exception->getCode()) ? $exception->getCode() : self::DEFAULT_STATUS_CODE;
    }

}