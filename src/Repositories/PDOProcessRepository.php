<?php

namespace VolkLms\Poc\Repositories;

use VolkLms\Poc\Models\Person;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Models\QueueAction;
use VolkLms\Poc\Models\Status;
use VolkLms\Poc\Models\Unit;
use VolkLms\Poc\Web\Response;

class PDOProcessRepository extends PDOAbstraction
{
  public function all(): array
  {
    $this->beginTransaction();

    $sql = "SELECT * FROM persons";

    $persons = $this->runSQL([
      'return'     => true,
      'multiple'   => true,
      'sql'        => $sql,
      'parameters' => []
    ]);

    $this->commit();

    return $persons;
  }

  public function createOrUpdate(Process $process): Process
  {
    try {
      $this->beginTransaction();

      $id = $process->getId();
  
      if (!$id) {
        $sql = 
          "INSERT INTO processes
            (
              person_id,
              unit_id,
              status_id,
              queue_action_id,
              name
          )
            VALUES (
            :person_id,
            :unit_id,
            :status_id,
            :queue_action_id,
            :name
          );";
  
        $name = $process->getName();
        $personId = $process->getPersonId();
        $unitId = $process->getUnitId();
        $statusId = $process->getStatusId();
        $queueActionId = $process->getQueueActionId();
  
        $this->runSQL([
          'return'     => false,
          'multiple'   => false,
          'sql'        => $sql,
          'parameters' => [
            'person_id'       => $personId,
            'unit_id'         => $unitId,
            'status_id'       => $statusId,
            'queue_action_id' => $queueActionId,
            'name'            => $name
          ]
        ]);

        $process = Process::createProcessWithId([
          'id'          => $this->lastInsertId(),
          'name'        => $name,
          'person'      => new Person($personId, ''),
          'status'      => new Status($unitId, ''),
          'unit'        => new Unit($statusId, ''),
          'queueAction' => new QueueAction($queueActionId, '')
        ]);
      } 
      $this->commit();

      return $process;
    } catch (\Throwable $th) {
      Response::statusCode(500)::json($th);
      exit;
    }
  }
}