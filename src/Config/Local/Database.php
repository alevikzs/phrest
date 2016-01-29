<?php

namespace PhRest\Config\Local;

use \Phalcon\Db\Adapter\Pdo;

    /**
 * Class Database
 * @package PhRest\Config\Local
 */
class Database {

    /**
     * @var string
     */
    private $adapter;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $live;

    /**
     * @var string
     */
    private $test;

    /**
     * @var Pdo
     */
    private $liveInstance;

    /**
     * @var Pdo
     */
    private $testInstance;

    /**
     * @return string
     */
    public function getAdapter() {
        return $this->adapter;
    }

    /**
     * @param string $adapter
     * @return $this
     */
    public function setAdapter($adapter) {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost($host) {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param string $user
     * @return $this
     */
    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getLive() {
        return $this->live;
    }

    /**
     * @param string $live
     * @return $this
     */
    public function setLive($live) {
        $this->live = $live;
        return $this;
    }

    /**
     * @return string
     */
    public function getTest() {
        return $this->test;
    }

    /**
     * @param string $test
     * @return $this
     */
    public function setTest($test) {
        $this->test = $test;
        return $this;
    }

    /**
     * @param string $user
     * @param string $live
     * @param string $test
     * @param string $password
     * @param string $adapter
     * @param string $host
     */
    public function __construct(
        $user = null,
        $live = null,
        $test = null,
        $password = '',
        $adapter = 'Postgresql',
        $host = 'localhost'
    ) {
        $this
            ->setUser($user)
            ->setLive($live)
            ->setTest($test)
            ->setPassword($password)
            ->setAdapter($adapter)
            ->setHost($host);
    }

    /**
     * @return Pdo
     */
    public function getLiveInstance() {
        if (is_null($this->liveInstance)) {
            $this->liveInstance = $this->createDatabase();
        }

        return  $this->liveInstance;
    }

    /**
     * @return Pdo
     */
    public function getTestInstance() {
        if (is_null($this->testInstance)) {
            $this->testInstance = $this->createDatabase(false);
        }

        return  $this->testInstance;
    }

    /**
     * @param bool $isLive
     */
    private function createDatabase($isLive = true) {
        $adapter = '\\Phalcon\\Db\\Adapter\\Pdo\\' . $this->getAdapter();

        return new $adapter([
            'host' => $this->getHost(),
            'username' => $this->getUser(),
            'password' => $this->getPassword(),
            'dbname' => $isLive ? $this->getLive() : $this->getTest()
        ]);
    }

}