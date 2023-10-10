<?php

namespace VolkLms\Poc\Models;

class Status 
{
  private int $id;
  private string $description;

  public function __construct(int $id, string $description) 
  {
    $this->id = $id;
    $this->description = $description;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getDescription(): string
  {
    return $this->description;
  }
}