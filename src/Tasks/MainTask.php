<?php

namespace PhRest\Tasks;

use \Phalcon\CLI\Task;

/**
 * Class MainTask
 * @package PhRest\Tasks
 */
class MainTask extends Task {

    public function mainAction() {
        echo "\nThis is the default task and the default action \n";
    }

}