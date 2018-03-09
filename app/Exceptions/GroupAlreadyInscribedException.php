<?php

namespace App\Exceptions;

use Exception;
use RuntimeException;

/**
 * Class GroupAlreadyInscribedException
 * @package App\Exceptions
 */
class GroupAlreadyInscribedException extends RuntimeException
{
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        parent::__construct("El grup ja està inscrit!", $code, $previous);
    }
}