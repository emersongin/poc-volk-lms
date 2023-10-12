<?php

namespace VolkLms\Poc\Exceptions;

use Exception;

class BadRequestException extends Exception {
    public function __construct($message = "", $statusCode = 400) {
        parent::__construct($message, $statusCode);
    }
}