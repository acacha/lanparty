<?php

namespace App\Exceptions;

use Exception;

/**
 * Class NotEnoughTicketsException.
 *
 * @package App\Exceptions
 */
class NotEnoughTicketsException extends \RuntimeException {
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        parent::__construct('No queden prou tickets!', $code, $previous);
    }
}
