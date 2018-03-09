<?php

namespace App\Exceptions;

use Exception;
use RuntimeException;

/**
 * Class UserAlreadyMemberOfGroup
 * @package App\Exceptions
 */
class UserAlreadyMemberOfGroup extends RuntimeException
{
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        parent::__construct("L'usuari ja és membre del grup!", $code, $previous);
    }
}