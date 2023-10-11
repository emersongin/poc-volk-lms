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
    return json_encode($data);
  }

}