<?php


namespace App\Exceptions;

use App\Constants\HttpStatus;
use Exception;

class InvalidCsrfTokenException extends Exception
{
    public function __construct($message, $code = HttpStatus::UNAUTHORIZED)
    {
        parent::__construct($message, $code);
    }

}
