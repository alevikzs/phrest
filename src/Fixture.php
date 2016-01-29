<?php

namespace PhRest;

/**
 * Class Fixture
 * @package PhRest
 */
abstract class Fixture {

    /**
     * @param array $list
     * @return mixed
     */
    public function getRandomValue(array $list) {
        $randomIndex = rand(0, count($list) - 1);

        return $list[$randomIndex];
    }

    /**
     * @return mixed
     */
    public abstract function getCollection();

}