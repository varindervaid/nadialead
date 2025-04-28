<?php

namespace App\Exceptions;

use Exception;

class CallRailException extends Exception
{
    public function __construct($message = ":attribute is invalid.", $code = 0)
    {
        parent::__construct($message, $code);
    }
}
