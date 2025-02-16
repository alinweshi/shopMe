<?php

namespace App\Exceptions;

use Exception;

class AuthorizationException extends Exception
{
    protected $message = 'You are not authorized to perform this action.';
}
