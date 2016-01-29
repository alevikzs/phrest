<?php

namespace PhRest;

use \Phalcon\Validation;

/**
 * Class RequestPayload
 * @package PhRest
 */
abstract class RequestPayload extends Json {

    /**
     * @param Validation $validator
     * @return Validation
     */
    abstract protected function validation(Validation $validator);

    /**
     * @return array
     */
    public function validate() {
        $validator = new Validation();
        $validator = $this->validation($validator);

        $messages = [];

        foreach ($validator->validate($this->getPublicProperties()) as $index => $message) {
            $messages[$index]['field'] = $message->getField();
            $messages[$index]['message'] = $message->getMessage();
            $messages[$index]['type'] = $message->getType();
        }

        return $messages;
    }

}