<?php

namespace VolkLms\Poc\Repositories;

class PDOQueueActionRepository extends PDOAbstraction
{
  public function findAll(): array
  {
    $this->beginTransaction();

    $sql = "SELECT 
              q.id, 
              q.description 
            FROM 
              queue_actions q 
            ORDER BY 
              description";

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