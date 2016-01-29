<?php

namespace PhRest;

/**
 * Trait TJsonSerializable
 * @package PhRest
 */
trait TJsonSerializable {

    /**
     * @return array
     */
    abstract public function getPublicProperties();

    /**
     * @return array
     */
    public function jsonSerialize() {
        return $this->getPublicProperties();
    }

}