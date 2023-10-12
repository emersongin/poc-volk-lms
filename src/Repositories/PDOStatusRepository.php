<?php

namespace VolkLms\Poc\Repositories;

class PDOStatusRepository extends PDOAbstraction
{
  public function findAll(): array
  {
    $this->beginTransaction();

    $sql = "SELECT id, description FROM status ORDER BY description";

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