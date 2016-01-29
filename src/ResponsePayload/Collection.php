<?php

namespace PhRest\ResponsePayload;

use \Phalcon\Mvc\Model\Criteria,

    \PhRest\ResponsePayload,
    \PhRest\ResponsePayload\Meta\Collection as MetaCollection;

/**
 * Class Collection
 * @package PhRest\ResponsePayload
 */
class Collection extends ResponsePayload {

    /**
     * @var Criteria
     */
    private $query;

    /**
     * @return Criteria
     */
    public function getQuery() {
        return $this->query;
    }

    /**
     * @param Criteria $query
     * @return $this
     */
    public function setQuery(Criteria $query) {
        $this->query = $query;
        return $this;
    }

    /**
     * @param Criteria $query
     * @param MetaCollection $meta
     */
    public function __construct(Criteria $query, MetaCollection $meta) {
        $this
            ->setQuery($query)
            ->setSuccess(true)
            ->setMeta($meta)
            ->createData();
    }

    /**
     * @return $this
     */
    private function createData() {
        /** @var MetaCollection $meta */
        $meta = $this->getMeta();

        $data = $this
            ->getQuery()
            ->limit(
                $meta->getLimit(),
                $meta->getOffset()
            )
            ->execute()
            ->toArray();

        return $this->setData($data);
    }

}