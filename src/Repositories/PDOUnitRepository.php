<?php

namespace VolkLms\Poc\Repositories;

class PDOUnitRepository extends PDOAbstraction
{
  public function findAll(): array
  {
    $this->beginTransaction();

    $sql = "SELECT 
              u.id, 
              u.number 
            FROM 
              units u 
            ORDER BY 
              number";

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