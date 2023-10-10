<?php

namespace VolkLms\Poc\Models;

class Unit 
{
  private int $id;
  private string $number;

  public function __construct(int $id, string $number) 
  {
    $this->id = $id;
    $this->number = $number;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getNumber(): string
  {
    return $this->number;
  }
}