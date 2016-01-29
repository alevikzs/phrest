<?php

namespace PhRest\Controller;

use \Phalcon\Http\Response,
    \Phalcon\Mvc\Model\Criteria,
    \Phalcon\Mvc\Model\Resultset as ResultSet,

    \PhRest\Controller,
    \PhRest\Http\Response as HttpResponse,
    \PhRest\RequestPayload\Collection as CollectionRequestPayload,
    \PhRest\ResponsePayload\Collection as CollectionResponsePayload,
    \PhRest\ResponsePayload\Meta\Collection as MetaCollection;

/**
 * Class Collection
 * @package PhRest\Controller
 * @method CollectionRequestPayload getPayload()
 */
abstract class Collection extends Controller {

    use TPayload;

    /**
     * @param Criteria $query
     * @return HttpResponse
     */
    public function response(Criteria $query) {
        if ($this->getPayload()->getOrder()) {
            $query->orderBy(
                $this->getPayload()->getOrderQuery()
            );
        }

        $response = new CollectionResponsePayload(
            $query,
            $this->createMeta($query)
        );

        return (new HttpResponse($response));
    }

    /**
     * @param Criteria $query
     * @return MetaCollection
     */
    private function createMeta(Criteria $query) {
        $metaQuery = clone $query;

        /** @var ResultSet $resultSet */
        $resultSet = $metaQuery->execute();

        return new MetaCollection(
            $resultSet->count(),
            $this->getPayload()->getPage(),
            $this->getPayload()->getLimit()
        );
    }

}