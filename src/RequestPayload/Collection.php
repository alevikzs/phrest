<?php

namespace PhRest\RequestPayload;

use \Phalcon\Validation,

    \PhRest\RequestPayload,
    \PhRest\RequestPayload\Collection\Order;

/**
 * Class Collection
 * @package PhRest\RequestPayload
 */
class Collection extends RequestPayload {

    /**
     * @var integer
     */
    private $limit;

    /**
     * @var integer
     */
    private $page;

    /**
     * @var Order[]
     */
    private $order;

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
     * @return Order[]
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * @param Order[] $order
     * @return $this
     * @mapper(class="\PhRest\RequestPayload\Collection\Order", isArray=true)
     */
    public function setOrder(array $order = []) {
        $this->order = $order;
        return $this;
    }

    /**
     * @param Order $order
     * @return $this
     */
    public function addOrder(Order $order) {
        $orders = $this->getOrder();
        $orders[] = $order;
        $this->setOrder($orders);
        return $this;
    }

    /**
     * @param integer $limit
     * @param integer $page
     * @param Order[] $order
     */
    public function __construct($limit = 20, $page = 1, array $order = []) {
        $this
            ->setLimit($limit)
            ->setPage($page)
            ->setOrder($order);
    }

    /**
     * @return integer
     */
    public function getOffset() {
        return $this->getLimit() * ($this->getPage() - 1);
    }

    /**
     * @return string|null
     */
    public function getOrderQuery() {
        $orderQuery = [];

        foreach ($this->getOrder() as $order) {
            $orderQuery[] = $order->getQuery();
        }

        return implode(',', $orderQuery);
    }

    /**
     * @param Validation $validator
     * @return Validation
     */
    public function validation(Validation $validator) {
        return $validator;
    }

    /**
     * @return array
     */
    public function getPublicProperties() {
        return [
            'limit' => $this->getLimit(),
            'page' => $this->getPage(),
            'order' => $this->getOrder(),
        ];
    }

}