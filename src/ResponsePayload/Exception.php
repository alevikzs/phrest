<?php

namespace PhRest\ResponsePayload;

use \Exception as BaseException,

    \PhRest\ResponsePayload,
    \PhRest\ResponsePayload\Meta;

/**
 * Class Exception
 * @package PhRest\ResponsePayload
 */
class Exception extends ResponsePayload {

    /**
     * @var BaseException
     */
    private $exception;

    /**
     * @return BaseException
     */
    public function getException() {
        return $this->exception;
    }

    /**
     * @param BaseException $exception
     * @return $this
     */
    public function setException(BaseException $exception) {
        $this->exception = $exception;
        return $this;
    }

    /**
     * @param BaseException $exception
     * @param Meta $meta
     */
    public function __construct(BaseException $exception, Meta $meta = null) {
        $this->setException($exception);

        parent::__construct($exception, $meta, false);
    }

}