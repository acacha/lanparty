<?php

namespace App\Exceptions;

use Exception;
use RuntimeException;

/**
 * Class InscriptionException
 * @package App\Exceptions
 */
class InscriptionException extends RuntimeException
{
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        parent::__construct("No s'ha pogut realitzar la inscripció (InscriptionException)", $code, $previous);
    }
}