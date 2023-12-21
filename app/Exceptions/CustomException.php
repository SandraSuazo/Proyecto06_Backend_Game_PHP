<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public static function createException($message, $code)
    {
        return new static($message, $code);
    }
}
