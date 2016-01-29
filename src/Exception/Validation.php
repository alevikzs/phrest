<?php

namespace PhRest\Exception;

/**
 * Class User
 * @package PhRest\Exception
 */
class Validation extends User {

    /**
     * @var array
     */
    private $errors;

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function setErrors(array $errors) {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param array $errors
     * @param string $message
     * @param int $code
     */
    public function __construct(array $errors, $message = 'Validation error', $code = 400) {
        $this->setErrors($errors);

        parent::__construct($message, $code);
    }

    /**
     * @return array
     */
    public function jsonSerialize() {
        return array_merge(
            [
                'errors' => $this->getErrors()
            ],
            parent::jsonSerialize()
        );
    }

}