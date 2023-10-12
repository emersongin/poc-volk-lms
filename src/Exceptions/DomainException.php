<?php

namespace VolkLms\Poc\Exceptions;

class DomainException extends BaseException {
  public function __construct($message = "", $statusCode = 400) {
      parent::__construct($message, $statusCode);
  }
}