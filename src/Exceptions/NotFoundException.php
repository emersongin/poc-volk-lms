<?php

namespace VolkLms\Poc\Exceptions;

class NotFoundException extends BaseException {
  public function __construct($message = "not found", $statusCode = 404) {
      parent::__construct($message, $statusCode);
  }
}