<?php

namespace PhRest\Bootstrap;

/**
 * Trait TLive
 * @package PhRest\Bootstrap
 */
trait TLive {

    /**
     * @return bool
     */
    public function isLive() {
        return true;
    }

    /**
     * @return bool
     */
    public function isTest() {
        return false;
    }

}