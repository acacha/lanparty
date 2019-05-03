<?php

namespace App\Exceptions;

use Exception;

/**
 * Class NotEnoughNumbersException.
 *
 * @package App\Exceptions
 */
class NotEnoughNumbersException extends \RuntimeException {
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        parent::__construct('No queden prou números!', $code, $previous);
    }
}
