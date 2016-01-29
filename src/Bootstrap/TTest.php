<?php

namespace PhRest\Bootstrap;

/**
 * Trait TTest
 * @package PhRest\Bootstrap
 */
trait TTest {

    /**
     * @return bool
     */
    public function isLive() {
        return false;
    }

    /**
     * @return bool
     */
    public function isTest() {
        return true;
    }

}