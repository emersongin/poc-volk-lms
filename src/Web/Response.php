<?php

namespace VolkLms\Poc\Web;

class Response 
{

  static function statusCode(int $code): Response
  {
    http_response_code($code);
    return new self();
  }

  static function json($data)
  {
    $statusCode = http_response_code();
    if ($statusCode !== 204) {
      header('Content-Type: application/json');
      echo json_encode($data);
    }
  }

  static function html($data)
  {
    $statusCode = http_response_code();
    if ($statusCode !== 204) {
      echo json_encode($data);
    }
  }

}