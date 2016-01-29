<?php

namespace PhRest\Tasks;

use \Phalcon\CLI\Task,

    \PhRest\PushNotifications\Queue\Receiver;

/**
 * Class PushNotificationsTask
 * @package PhRest\Tasks
 */
class PushNotificationsTask extends Task {

    public function receiverAction() {
        (new Receiver())->listen();
    }

}