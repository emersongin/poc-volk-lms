<?php

namespace VolkLms\Poc\Exceptions;

class BadGatewayException extends BaseException {
    public function __construct($message = "", $statusCode = 502) {
        parent::__construct($message, $statusCode);
    }
}