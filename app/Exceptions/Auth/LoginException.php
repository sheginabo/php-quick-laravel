<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class LoginException extends BaseException
{
    public function __construct($message = "", $statusCode = 400, $target = "")
    {
        parent::__construct($message, $statusCode, $target);
    }
}
