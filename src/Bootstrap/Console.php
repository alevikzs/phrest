<?php

namespace PhRest\Bootstrap;

use \Phalcon\CLI\Console as BaseConsole,
    \Phalcon\Di\FactoryDefault\Cli;

/**
 * Class Console
 * @package PhRest\Bootstrap
 */
abstract class Console extends BaseConsole implements IBoot {

    /**
     * @var array
     */
    private $rawArguments;

    /**
     * @var array
     */
    private $formattedArguments;

    /**
     * @return array
     */
    public function getRawArguments() {
        return $this->rawArguments;
    }

    /**
     * @param array $arguments
     * @return Console
     */
    protected function setRawArguments(array $arguments) {
        $this->rawArguments = $arguments;
        return $this;
    }

    /**
     * @return array
     */
    public function getFormattedArguments() {
        return $this->formattedArguments;
    }

    /**
     * @param array $arguments
     * @return Console
     */
    protected function setFormattedArguments(array $arguments) {
        $this->formattedArguments = $arguments;
        return $this;
    }

    /**
     * @param array $arguments
     */
    public function __construct(array $arguments = []) {
        $this
            ->setRawArguments($arguments)
            ->createFormattedArguments();
    }

    public function go() {
        $this
            ->createDependencies()
            ->handle($this->getFormattedArguments());
    }

    private function createFormattedArguments() {
        $formattedArguments = [];

        if (count($this->getRawArguments()) > 1) {
            foreach($this->getRawArguments() as $index => $argument) {
                if($index == 1) {
                    $formattedArguments['task'] = $this->createHandlerName($argument);
                } elseif($index == 2) {
                    $formattedArguments['action'] = $argument;
                } elseif($index >= 3) {
                    $formattedArguments['params'][] = $argument;
                }
            }
        } else {
            $formattedArguments['task'] = $this->createHandlerName();
        }

        $this->setFormattedArguments($formattedArguments);
    }

    /**
     * @param string $argument
     * @return string
     */
    private function createHandlerName($argument = 'main') {
        $className = ucfirst($argument);

        $appPath = '\\PhRest\\Tasks\\';

        if (class_exists($appPath . $className)) {
            return $appPath . $className;
        }

        $risePath = '\\PhRest\\Tasks\\';

        return $risePath . $className;
    }

    /**
     * @return $this
     */
    public function createDependencies() {
        $dependency = new Cli();

        $dependency->set('db', function() {
            return $this->getDatabase();
        });

        $dependency->setShared('application', $this);

        $this->setDI($dependency);

        return $this;
    }

}