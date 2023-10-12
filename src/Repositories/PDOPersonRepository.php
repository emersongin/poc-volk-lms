<?php

namespace VolkLms\Poc\Repositories;

class PDOPersonRepository extends PDOAbstraction
{
  public function findAll(): array
  {
    $this->beginTransaction();

    $sql = "SELECT 
              p.id, 
              p.fullname 
            FROM 
              persons p 
            ORDER BY 
              fullname";

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