<?php

namespace PhRest\PushNotifications\Queue;

use \PhpAmqpLib\Message\AMQPMessage,

    \PhRest\PushNotifications\Queue;

/**
 * Class Sender
 * @package PhRest\PushNotifications\Queue
 */
class Sender extends Queue {

    /**
     * @param Message $message
     * @return $this
     */
    public function publish(Message $message) {
        $message = new AMQPMessage(json_encode($message));

        $this
            ->getChannel()
            ->basic_publish($message, '', $this->getQueue());

        return $this;
    }

    /**
     * @param Message[] $messages
     * @return $this
     */
    public function publishAll(array $messages) {
        /** @var Message $message */
        foreach ($messages as $message) {
            $this->publish($message);
        }

        return $this;
    }

}