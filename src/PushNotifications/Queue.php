<?php

namespace PhRest\PushNotifications;

use \PhpAmqpLib\Channel\AMQPChannel,
    \PhpAmqpLib\Connection\AbstractConnection,
    \PhpAmqpLib\Connection\AMQPConnection;

/**
 * Class Queue
 * @package PhRest\PushNotifications
 */
abstract class Queue {

    /**
     * @var AbstractConnection
     */
    private $connection;

    /**
     * @var string
     */
    private $queue;

    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @return AbstractConnection
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * @param AbstractConnection $connection
     * @return $this
     */
    protected function setConnection(AbstractConnection $connection) {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @return string
     */
    public function getQueue() {
        return $this->queue;
    }

    /**
     * @param string $queue
     * @return $this
     */
    protected function setQueue($queue) {
        $this->queue = $queue;

        return $this;
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel() {
        return $this->channel;
    }

    /**
     * @param AMQPChannel $channel
     * @return $this
     */
    protected function setChannel(AMQPChannel $channel) {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @param string $queue
     * @param AbstractConnection $connection
     */
    public function __construct($queue = 'notifications', AbstractConnection $connection = null) {
        if (is_null($connection)) {
            $connection = new AMQPConnection(
                'localhost',
                5672,
                'guest',
                'guest'
            );
        }

        $this
            ->setConnection($connection)
            ->setChannel($connection->channel())
            ->setQueue($queue)
            ->openQueue();
    }

    /**
     * @return $this
     */
    private function openQueue() {
        $this
            ->getChannel()
            ->queue_declare(
                $this->getQueue(),
                false,
                false,
                false,
                false
            );

        return $this;
    }

    /**
     * @return $this
     */
    public function close() {
        $this->getChannel()->close();
        $this->getConnection()->close();

        return $this;
    }

}