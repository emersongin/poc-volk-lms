<?php

namespace VolkLms\Poc\Web;

class Response 
{

  public static function statusCode(int $code): Response
  {
    http_response_code($code);
    return new self();
  }

  public static function json($data)
  {
    $statusCode = http_response_code();
    if ($statusCode !== 204) {
      header('Content-Type: application/json');
      echo json_encode($data);
    }
  }

  public static function html($data)
  {
    $statusCode = http_response_code();
    if ($statusCode !== 204) {
      echo $data;
    }
  }

  public static function addHeaders(array $headers) {
    foreach ($headers as $key => $value) {
      header("$key: $value");
    }
    return new self();
  }

}