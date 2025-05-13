<?php


namespace App\Exceptions;

use App\Constants\HttpStatus;
use Exception;

class NotFoundException extends Exception
{
    public function __construct($message, $code = HttpStatus::NOT_FOUND)
    {
        parent::__construct($message, $code);
    }

}
