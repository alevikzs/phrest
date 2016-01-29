<?php

namespace PhRest\Config;

use \PhMap\MapperTrait,

    \PhRest\Config\Local\Database,
    \PhRest\Config\Local\Security;

/**
 * Class Local
 * @package PhRest\Config
 */
class Local {

    use MapperTrait;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var Database
     */
    private $database;

    /**
     * @var $this
     */
    private static $instance;

    /**
     * @return Security
     */
    public function getSecurity() {
        return $this->security;
    }

    /**
     * @param Security|null $security
     * @return $this
     * @mapper(class="\PhRest\Config\Local\Security")
     */
    public function setSecurity(Security $security = null) {
        $this->security = $security;
        return $this;
    }

    /**
     * @return Database
     */
    public function getDatabase() {
        return $this->database;
    }

    /**
     * @param Database|null $database
     * @return $this
     * @mapper(class="\PhRest\Config\Local\Database")
     */
    public function setDatabase(Database $database = null) {
        $this->database = $database;

        return $this;
    }

    /**
     * @param Database $database
     * @param Security $security
     */
    public function __construct(Database $database = null, Security $security = null) {
        $this
            ->setDatabase($database)
            ->setSecurity($security);
    }

    /**
     * @return $this
     */
    public function save() {
        file_put_contents(self::getPath(), json_encode($this));
        return $this;
    }

    /**
     * @return $this
     */
    public static function get() {
        if (is_null(self::$instance)) {
            $json = file_get_contents(self::getPath());
            self::$instance = static::staticMap($json);
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    private static function getPath() {
        return dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'local.json';
    }

}