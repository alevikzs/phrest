<?php

namespace PhRest;

use \GuzzleHttp\Client,
    \GuzzleHttp\Message\ResponseInterface;

/**
 * Class ApiTestCase
 * @package PhRest
 */
abstract class ApiTestCase extends \PHPUnit_Framework_TestCase {

    /** @var  Client */
    private $http;

    /**
     * @var array
     */
    private $stub;

    /**
     * @return Client
     */
    public function getHttp() {
        return $this->http;
    }

    /**
     * @param Client $http
     * @return ApiTestCase
     */
    public function setHttp(Client $http) {
        $this->http = $http;
        return $this;
    }

    /**
     * @return array
     */
    public function getStub() {
        return $this->stub;
    }

    /**
     * @param mixed $stub
     * @return ApiTestCase
     */
    public function setStub($stub) {
        $this->stub = $stub;
        return $this;
    }

    /**
     * @return void
     */
    protected final function setUp() {
        $this
            ->setHttp(new Client([
                'base_url' => [
                    'http://test.ph.com',
                    ['version' => '1']
                ],
                'defaults' => [
                    'exceptions' => false,
                ]
            ]))
            ->initStub();
    }

    /**
     * @param string $url
     * @param array|null $data
     * @return ResponseInterface
     */
    public function post($url, array $data = null) {
        if (is_null($data)) {
            $body = '{}';
        } else {
            $body = json_encode($data);
        }

        return $this
            ->getHttp()
            ->post($url, ['body' => $body]);
    }

    /**
     * @param string $url
     * @param array|null $data
     * @return ResponseInterface
     */
    public function put($url, array $data = null) {
        if (is_null($data)) {
            $body = '{}';
        } else {
            $body = json_encode($data);
        }

        return $this
            ->getHttp()
            ->put($url, ['body' => $body]);
    }

    /**
     * @param $url
     * @return ResponseInterface
     */
    public function get($url) {
        return $this->getHttp()->get($url);
    }

    /**
     * @param $url
     * @return ResponseInterface
     */
    public function delete($url) {
        return $this->getHttp()->delete($url);
    }

    /**
     * @param mixed $actual
     */
    public function assertEmptyStr($actual) {
        $this->assertEquals('', $actual);
    }

    /**
     * @return ApiTestCase
     */
    private function initStub() {
        $this->clearStub();

        $this
            ->setStub($this->createStub())
            ->saveStub();

        return $this;
    }

    /**
     * @return void
     */
    abstract protected function saveStub();

    /**
     * @return void
     */
    abstract protected function clearStub();

    /**
     * @return array
     */
    abstract protected function createStub();

}