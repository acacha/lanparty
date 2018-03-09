<?php

namespace App\Exceptions;

use Exception;
use RuntimeException;

/**
 * Class UserAlreadyInscribedException
 * @package App\Exceptions
 */
class UserAlreadyInscribedException extends RuntimeException
{
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        parent::__construct("L'usuari ja està inscrit!", $code, $previous);
    }
}