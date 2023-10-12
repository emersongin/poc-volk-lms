<?php

namespace VolkLms\Poc\Exceptions;

class UnauthorizedException extends BaseException {
    public function __construct($message = "", $statusCode = 401) {
        parent::__construct($message, $statusCode);
    }
}