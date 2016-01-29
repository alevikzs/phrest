<?php

namespace PhRest;

use \Phalcon\Mvc\Controller as BaseController,
    \Phalcon\Http\Response;

/**
 * Class Controller
 * @package PhRest
 */
abstract class Controller extends BaseController {

    /**
     * @return Response
     */
    public abstract function runAction();

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments) {
        $parameter = lcfirst(substr($name, 3));
        $parameters = $this->getParams();
        if (isset($parameters[$parameter])) {
            return $parameters[$parameter];
        }
        return null;
    }

    /**
     * @return array
     */
    public function getParams() {
        return $this
            ->router
            ->getParams();
    }

}