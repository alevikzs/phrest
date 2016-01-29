<?php

namespace PhRest\ResponsePayload\Meta;

use \PhRest\ResponsePayload\Meta;

/**
 * Class Collection
 * @package PhRest\ResponsePayload\Meta
 */
class Collection extends Meta {

    /**
     * @var integer
     */
    private $total;

    /**
     * @var integer
     */
    private $page;

    /**
     * @var integer
     */
    private $limit;

    /**
     * @var boolean
     */
    private $hasNext;

    /**
     * @return integer
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * @param integer $total
     * @return $this
     */
    public function setTotal($total) {
        $this->total = $total;
        return $this;
    }

    /**
     * @return integer
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * @param integer $page
     * @return $this
     */
    public function setPage($page) {
        $this->page = $page;
        return $this;
    }

    /**
     * @return integer
     */
    public function getLimit() {
        return $this->limit;
    }

    /**
     * @param integer $limit
     * @return $this
     */
    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return boolean
     */
    public function hasNext() {
        return $this->hasNext;
    }

    /**
     * @param boolean $hasNext
     * @return $this
     */
    public function setHasNext($hasNext) {
        $this->hasNext = $hasNext;
        return $this;
    }

    /**
     * @param integer $total
     * @param integer $page
     * @param integer $limit
     */
    public function __construct($total, $page, $limit) {
        $this
            ->setTotal($total)
            ->setPage($page)
            ->setLimit($limit)
            ->createHasNext();
    }

    /**
     * @return $this
     */
    private function createHasNext() {
        $hasNext = $this->getTotal() - $this->getPage() * $this->getLimit() > 0;

        return $this->setHasNext($hasNext);
    }

    /**
     * @return integer
     */
    public function getOffset() {
        return $this->getLimit() * ($this->getPage() - 1);
    }

    /**
     * @return array
     */
    public function getPublicProperties() {
        return [
            'total' => $this->getTotal(),
            'page' => $this->getPage(),
            'limit' => $this->getLimit(),
            'hasNext' => $this->hasNext()
        ];
    }

}