<?php

namespace VolkLms\Poc\Exceptions;

class BadRequestException extends BaseException {
    public function __construct($message = "", $statusCode = 400) {
        parent::__construct($message, $statusCode);
    }
}