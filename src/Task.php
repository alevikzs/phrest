<?php

namespace PhRest;

use \Phalcon\CLI\Task as BaseTask,
    \Phalcon\Db\Adapter\Pdo,

    \PhRest\Bootstrap\Console;

/**
 * Class Task
 * @package PhRest
 * @property Console $application
 */
class Task extends BaseTask {

    /**
     * @return Pdo
     */
    protected function getDb() {
        return $this->db;
    }

    /**
     * @return Console
     */
    protected function getApplication() {
        return $this->application;
    }

}