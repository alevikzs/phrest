<?php

namespace PhRest\Controllers;

use \PhRest\Controller,
    \PhRest\Exception\User as UserException;

/**
 * Class Missing
 * @package PhRest\Controllers
 */
class MissingController extends Controller {

    /**
     * @throws UserException
     */
    public function runAction() {
        throw new UserException('Not Found', 404);
    }

}