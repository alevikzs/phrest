<?php

namespace PhRest\Http;

use \Phalcon\Http\Response as BaseResponse,

    \PhRest\ResponsePayload;

/**
 * Class Response
 * @package PhRest\Http
 */
class Response extends BaseResponse {

    /**
     * @param ResponsePayload $body
     * @param int|null $code
     * @param string|null $status
     */
    public function __construct(ResponsePayload $body, $code = null, $status = null) {
        parent::__construct(null, $code, $status);
        $this->setContentType('application/json');
        $this->setHeader('Access-Control-Allow-Origin', '*');
        $this->setHeader('Access-Control-Allow-Methods', 'GET,HEAD,PUT,PATCH,POST,DELETE');
        $this->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization');
        $this->setJsonContent($body);
    }

    /**
     * @return array
     */
    protected function getStatusCodes() {
        return [
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            509 => 'Bandwidth Limit Exceeded'
        ];
    }

    /**
     * @param integer $code
     * @return bool
     */
    protected function isStandardCode($code) {
        return array_key_exists($code, $this->getStatusCodes());
    }

    /**
     * @param integer $code
     * @return string|null
     */
    protected function getStatusMessage($code) {
        return isset($this->getStatusCodes()[$code]) ? $this->getStatusCodes()[$code] : null;
    }

}