<?php

namespace VolkLms\Poc\Exceptions;

use Exception;

class BaseException extends Exception {
  protected int $statusCode;

  public function __construct($message = "", $statusCode = 500) {
      parent::__construct($message, $statusCode);
      $this->statusCode = $statusCode;
  }

  public function getStatusCode() {
    return $this->statusCode;
  }
}