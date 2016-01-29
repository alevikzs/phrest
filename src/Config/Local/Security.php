<?php

namespace PhRest\Config\Local;

use \Phalcon\Security as PhalconSecurity;

/**
 * Class Security
 * @package PhRest\Config\Local
 */
class Security {

    /**
     * @var string
     */
    private $salt;

    /**
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * @param string $salt
     * @return $this
     */
    public function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    /**
     * @param string|null $salt
     */
    public function __construct($salt = null) {
        if (is_null($salt)) {
            $salt = $this->createSalt();
        }

        $this->setSalt($salt);
    }

    /**
     * @return string
     */
    private function createSalt() {
        $security = new PhalconSecurity();
        $security->setRandomBytes(64);
        return $security->getSaltBytes();
    }

}