<?php

namespace VolkLms\Poc\Models;

class Person 
{
  private int $id;
  private string $fullname;

  public function __construct(int $id, string $fullname) 
  {
    $this->id = $id;
    $this->fullname = $fullname;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getFullname(): string
  {
    return $this->fullname;
  }
}