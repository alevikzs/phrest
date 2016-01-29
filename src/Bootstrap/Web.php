<?php

namespace PhRest\Bootstrap;

use \Exception,

    \Phalcon\Http\Response,
    \Phalcon\Mvc\Application,
    \Phalcon\DI\FactoryDefault,
    \Phalcon\Db\Adapter\Pdo,
    \Phalcon\Mvc\Router,
    \Phalcon\Mvc\View,

    \PhRest\Exception\Error as ErrorException,
    \PhRest\Http\Response\Error as ErrorResponse,
    \PhRest\ResponsePayload\Exception as ResponsePayloadException,

    \App\Config\Routes;

/**
 * Class Boot
 * @package PhRest
 */
abstract class Web extends Application implements  IBoot {

    public function go() {
        $this->notDisplayErrors();
        $this->setCustomErrorHandler();
        $this->registerShutdown();

        try {
            $this
                ->createDependencies()
                ->handle()
                ->send();
        } catch (Exception $exception) {
            $this->sendError($exception);
        }
    }

    /**
     * @return $this
     */
    public function createDependencies() {
        $dependency = new FactoryDefault();

        $dependency->set('db', function() {
            return $this->getDatabase();
        });

        $dependency->set('router', function() {
            $router = new Router(false);

            $routes = Routes::get();

            foreach($routes as $group => $controllers){
                foreach ($controllers as $controller) {
                    $router->add(
                        $controller['route'],
                        [
                            'namespace' => "App\\Controllers\\$group",
                            'controller' => $controller['class'],
                            'action' => 'run'
                        ],
                        $controller['method']
                    );
                }
            }

            $router->notFound([
                'namespace' => 'PhRest\\Controllers',
                'controller' => 'Missing',
                'action' => 'run'
            ]);

            return $router;
        });

        $dependency->set('view', function() {
            return new View();
        }, true);

        $this->setDI($dependency);

        return $this;
    }

    private function notDisplayErrors() {
        ini_set('display_errors', false);
    }

    protected function setCustomErrorHandler() {
        $errorHandler = function($type, $message, $file, $line) {
            if (!error_reporting()) {
                return false;
            }

            throw new ErrorException($message, 0, $type, $file, $line);
        };

        set_error_handler($errorHandler);
    }

    protected function registerShutdown() {
        $shutdownFunction = function () {
            $lastError = error_get_last();

            if ($lastError) {
                $exception = new ErrorException(
                    $lastError['message'],
                    0,
                    $lastError['type'],
                    $lastError['file'],
                    $lastError['line']
                );

                $this->sendError($exception);
            }
        };

        register_shutdown_function($shutdownFunction);
    }

    /**
     * @param Exception $exception
     */
    protected function sendError(Exception $exception) {
        (new ErrorResponse(
            new ResponsePayloadException($exception)
        ))->send();
    }

}