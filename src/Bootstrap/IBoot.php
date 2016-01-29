<?php

namespace PhRest\Bootstrap;

use \Phalcon\Db\Adapter\Pdo;

/**
 * Interface IBoot
 * @package PhRest\Bootstrap
 */
interface IBoot {

    public function go();

    /**
     * @return IBoot
     */
    public function createDependencies();

    /**
     * @return bool
     */
    public function isLive();

    /**
     * @return bool
     */
    public function isTest();

    /**
     * @return Pdo
     */
    public function getDatabase();

}