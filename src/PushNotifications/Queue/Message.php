<?php

namespace PhRest\PushNotifications\Queue;

/**
 * Class Message
 * @package PhRest\PushNotifications\Queue
 */
class Message {

    /**
     * @var string
     */
    private $token;


    /**
     * @var mixed
     */
    private $payload;

    /**
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token) {
        $this->token = $token;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayload() {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     * @return $this
     */
    public function setPayload($payload) {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @param string $token
     * @param mixed $payload
     */
    public function __construct($token, $payload) {
        $this
            ->setToken($token)
            ->setPayload($payload);
    }

}