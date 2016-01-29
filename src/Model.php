<?php

namespace PhRest;

use \JsonSerializable,

    \Phalcon\Mvc\Model as BaseModel;

/**
 * Class Model
 * @package PhRest
 * @property integer $id
 */
abstract class Model extends BaseModel implements JsonSerializable {

    use TJsonSerializable;

    /**
     * @return integer
     */
    public static function getNextId() {
        return self::maximum(['column' => 'id']) + 1;
    }

    /**
     * @return $this
     */
    public function truncate() {
        $this
            ->getWriteConnection()
            ->query('TRUNCATE TABLE ' . $this->getSource() . ' RESTART IDENTITY')
            ->execute();

        return $this;
    }

    public function initialize() {
        $this->keepSnapshots(true);
    }

    /**
     * @return bool
     */
    public function isNew() {
        return is_null($this->id);
    }

}