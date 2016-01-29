<?php

namespace PhRest\Tasks;

use \PhRest\Task,
    \PhRest\Migration;

/**
 * Class MigrationTask
 * @package PhRest\Tasks
 */
class MigrationTask extends Task {

    public function mainAction() {
       $this->upAction();
    }

    /**
     * @param array $params
     */
    public function addAction(array $params) {
        $name = $this->createName(array_pop($params));
        $template = file_get_contents($this->getTemplateFile());
        $template = str_replace('#name#', $name, $template);
        file_put_contents($this->getMigrationDirectory() . $name . '.php', $template);
        echo "\nMigration $name was created\n";
    }

    public function upAction() {
        $files = $this->getMigrationFiles();
        foreach ($files as $file) {
            if (!$this->isAlreadySuccess($file)) {
                $this->up($file);
            }
        }
    }

    /**
     * @param array $params
     */
    public function downAction(array $params) {
        $count = (int) array_pop($params);

        $migrations = $this->getSuccessMigrations(true);

        for ($index = 0; $index < $count; $index++) {
            if (isset($migrations[$index])) {
                $this->down($migrations[$index]);
            } else {
                break;
            }
        }
    }

    /**
     * @return string
     */
    public function getMigrationDirectory() {
        return getcwd() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Migrations' . DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getTemplateFile() {
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'migration.tpl';
    }

    /**
     * @param string $name
     * @return string
     */
    private function createName($name) {
        return 'M_' . time() . '_' . $name;
    }

    /**
     * @return string
     */
    private function getSuccessLogFile() {
        $logFileName = '.migrations';

        if ($this->getApplication()->isTest()) {
            $logFileName .= '_test';
        }

        return $this->getPhalconDirectory() . $logFileName;
    }

    /**
     * @return string
     */
    private function getPhalconDirectory() {
        return getcwd() . DIRECTORY_SEPARATOR . '.phalcon' . DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $fileName
     * @return boolean
     */
    private function isAlreadySuccess($fileName) {
        $result = false;

        if (is_file($this->getSuccessLogFile())) {
            $successLog = file_get_contents($this->getSuccessLogFile());
            $clearName = $this->getClearName($fileName);
            if (strpos($successLog, $clearName) !== false) {
                $result = true;
            }
        } else {
            file_put_contents($this->getSuccessLogFile(), '');
        }

        return $result;
    }

    /**
     * @param string $fileName
     * @return string
     */
    private function getClearName($fileName) {
        $pattern = '/^(.+)\.php$/';
        preg_match($pattern, $fileName, $matches);
        return $matches[1];
    }

    /**
     * @param string $fileName
     */
    private function up($fileName) {
        $clearName = $this->getClearName($fileName);

        $class = '\\App\\Migrations\\' . $clearName;
        /** @var Migration $instance */
        $instance = new $class();
        $instance->safeUp();

        $this->addSuccessMigration($clearName);
    }

    /**
     * @param string $name
     */
    private function down($name) {
        $class = '\\App\\Migrations\\' . $name;
        /** @var Migration $instance */
        $instance = new $class();
        $instance->safeDown();

        $this->removeSuccessMigration($name);
    }

    /**
     * @param boolean $reverse
     * @return array
     */
    private function getMigrationFiles($reverse = false) {
        $files = scandir($this->getMigrationDirectory());
        $files = array_diff($files, ['.', '..']);

        if ($reverse) {
            $files = array_reverse($files);
        }

        return $files;
    }

    /**
     * @param boolean $reverse
     * @return array
     */
    private function getSuccessMigrations($reverse = false) {
        $successLog = file_get_contents($this->getSuccessLogFile());
        $migrations = explode("\n", $successLog);

        if(($key = array_search('', $migrations)) !== false) {
            unset($migrations[$key]);
        }

        if ($reverse) {
            $migrations = array_reverse($migrations);
        }

        return $migrations;
    }

    /**
     * @param string $name
     */
    private function removeSuccessMigration($name) {
        $successLog = file_get_contents($this->getSuccessLogFile());
        $successLog = str_replace("$name\n", '', $successLog);

        file_put_contents($this->getSuccessLogFile(), $successLog);
    }

    /**
     * @param string $name
     */
    private function addSuccessMigration($name) {
        file_put_contents($this->getSuccessLogFile(), "$name\n", FILE_APPEND);
    }

}