<?php

namespace PhRest;

/**
 * Class Migration
 * @package PhRest
 */
abstract class Migration extends Task {

    public function safeUp() {
        $this->run('up');
    }

    public function safeDown() {
        $this->run('down');
    }

    /**
     * @param string $direction
     */
    private function run($direction) {
        $this->getDb()->begin();
        try {
            $this->$direction();
            $this->getDb()->commit();
        } catch (\Exception $error) {
            $this->getDb()->rollback();
        }
    }

    abstract protected function up();

    abstract protected function down();

}