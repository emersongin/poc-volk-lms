<?php

namespace VolkLms\Poc\Web;

class Request 
{
  private array $queryParams;
  private array $body;

  public function __construct(array $queryParams, array $body)
  {
    $this->queryParams = $queryParams;
    $this->body = $body;
  }

  public function getParam(string $param) {
    if (isset($this->body[$param])) {
        return $this->body[$param];
    } elseif (isset($this->queryParams[$param])) {
        return $this->queryParams[$param];
    } 
    return null;
}

  public function getParams(): array
  {
    return $this->queryParams;
  }

  public function getBody(): array
  {
    return $this->body;
  }
}