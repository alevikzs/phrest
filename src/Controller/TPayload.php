<?php

namespace PhRest\Controller;

use \Phalcon\Http\Response,
    \Phalcon\Http\Request,
    \Phalcon\Annotations\Adapter\Memory as MemoryAdapter,

    \PhRest\RequestPayload,
    \PhRest\Controller,
    \PhRest\Exception\Validation as ValidationException;

/**
 * Trait TPayload
 * @package PhRest
 * @property Request $request
 */
trait TPayload {

    /**
     * @var RequestPayload
     */
    private $payload;

    /**
     * @return RequestPayload
     */
    public function getPayload() {
        return $this->payload;
    }

    /**
     * @param RequestPayload $payload
     * @return $this
     */
    protected function setPayload(RequestPayload $payload) {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @throws ValidationException
     */
    public function onConstruct() {
        $rawBody = $this->request->getRawBody();

        /** @var RequestPayload $requestPayloadClass */
        $requestPayloadClass = (new MemoryAdapter())
            ->get(get_called_class())
            ->getClassAnnotations()
            ->get('payload')
            ->getArgument('class');

        $this->setPayload($requestPayloadClass::staticMap($rawBody));

        $errors = $this->getPayload()->validate();

        if ($errors) {
            throw new ValidationException($errors);
        }
    }


    /**
     * @param boolean $isAssociative
     * @return mixed
     */
    public function getRawPayload($isAssociative = true) {
        return $this
            ->request
            ->getJsonRawBody($isAssociative);
    }

}