<?php

namespace App\Exceptions;

class ValidationException extends \Exception
{

    private array $errors = [];

    public function __construct($message, $code = 0, array $errors = [])
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}