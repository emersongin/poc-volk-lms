<?php

namespace VolkLms\Poc\Repositories;

class PDOUnitRepository extends PDOAbstraction
{
  public function all(): array
  {
    $this->beginTransaction();

    $sql = "SELECT id, number FROM units ORDER BY number";

    $persons = $this->runSQL([
      'return'     => true,
      'multiple'   => true,
      'sql'        => $sql,
      'parameters' => []
    ]);

    $this->commit();

    return $persons;
  }
}