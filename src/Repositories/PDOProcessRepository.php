<?php

namespace VolkLms\Poc\Repositories;

use VolkLms\Poc\Exceptions\DomainException;
use VolkLms\Poc\Models\Person;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Models\QueueAction;
use VolkLms\Poc\Models\QueueIntegration;
use VolkLms\Poc\Models\Status;
use VolkLms\Poc\Models\Unit;

class PDOProcessRepository extends PDOAbstraction
{
  private function mapProcess($dbProcess)
  {
    if ($dbProcess['queue_id'] ?? null) {
      return Process::createProcessWithQueueIntegration([
        'id'               => $dbProcess['id'],
        'name'             => $dbProcess['name'],
        'person'           => new Person($dbProcess['person_id'], $dbProcess['person_fullname']),
        'status'           => new Status($dbProcess['status_id'], $dbProcess['status_description']),
        'unit'             => new Unit($dbProcess['unit_id'], $dbProcess['unit_number']),
        'queueAction'      => new QueueAction($dbProcess['queue_action_id'], $dbProcess['queue_action_description']),
        'createdAt'        => $dbProcess['created_at'],
        'updatedAt'        => $dbProcess['updated_at'],
        'queueIntegration' => new QueueIntegration(
          $dbProcess['queue_integration_id'],
          $dbProcess['queue_integration_status_id'],
          $dbProcess['queue_integration_action_id'],
          $dbProcess['queue_integration_updated_at']
        )
      ]);
    }
    return Process::createProcessWithId([
      'id'          => $dbProcess['id'],
      'name'        => $dbProcess['name'],
      'person'      => new Person($dbProcess['person_id'], $dbProcess['person_fullname']),
      'status'      => new Status($dbProcess['status_id'], $dbProcess['status_description']),
      'unit'        => new Unit($dbProcess['unit_id'], $dbProcess['unit_number']),
      'queueAction' => new QueueAction($dbProcess['queue_action_id'], $dbProcess['queue_action_description']),
      'createdAt'   => $dbProcess['created_at'],
      'updatedAt'   => $dbProcess['updated_at'],
    ]);
  }
  
  public function count(array $filters): int
  {
    $this->beginTransaction();

    $sql = 
      "SELECT
        COUNT(*) as total
      FROM processes p
      WHERE
        (p.id = :search_param OR p.name LIKE CONCAT('%', :search_param, '%'))
      ORDER BY 
        p.created_at DESC";

    $dbProcesses = $this->runSQL([
      'return'     => true,
      'multiple'   => false,
      'sql'        => $sql,
      'parameters' => [
        'search_param' => $filters['searchParam'] ?? NULL,
      ]
    ]);
    $this->commit();
    return $dbProcesses['total'];
  }

  public function findAll(array $filters): array
  {
    $this->beginTransaction();

    if (isset($filters['offset'])) $offset = (int) $filters['offset'];
    if (isset($filters['limit'])) $limit = (int) $filters['limit'];

    $sql = 
      "SELECT
        p.id,
        p.person_id,
        ps.fullname as person_fullname,
        p.unit_id,
        u.number as unit_number,
        p.status_id,
        s.description as status_description,
        p.queue_action_id,
        q.description as queue_action_description,
        p.name,
        p.created_at,
        p.updated_at
      FROM processes p
      JOIN persons ps ON ps.id = p.person_id
      JOIN units u ON u.id = p.unit_id
      JOIN status s ON s.id = p.status_id
      JOIN queue_actions q ON q.id = p.queue_action_id
      WHERE
        (p.id = :search_param OR p.name LIKE CONCAT('%', :search_param, '%'))
      ORDER BY 
        id DESC
      LIMIT {$limit} 
      OFFSET {$offset}";

    $dbProcesses = $this->runSQL([
      'return'     => true,
      'multiple'   => true,
      'sql'        => $sql,
      'parameters' => [
        'search_param' => $filters['searchParam'] ?? NULL,
      ]
    ]);
    $this->commit();
    return array_map([$this, 'mapProcess'], $dbProcesses);
  }

  public function findById(int $id): Process | null
  {
    $this->beginTransaction();

    $sql = 
      "SELECT
        p.id,
        p.person_id,
        ps.fullname as person_fullname,
        p.unit_id,
        u.number as unit_number,
        p.status_id,
        s.description as status_description,
        p.queue_action_id,
        q.description as queue_action_description,
        p.name,
        p.created_at,
        p.updated_at,
        pq.queue_id as queue_integration_id,
        pq.queue_status_id as queue_integration_status_id,
        pq.queue_action_id as queue_integration_action_id,
        pq.updated_at as queue_integration_updated_at
      FROM processes p
      JOIN persons ps ON ps.id = p.person_id
      JOIN units u ON u.id = p.unit_id
      JOIN status s ON s.id = p.status_id
      JOIN queue_actions q ON q.id = p.queue_action_id
      LEFT JOIN process_queues pq ON pq.process_id = p.id
      WHERE
        p.id = :process_id";

    $dbProcess = $this->runSQL([
      'return'     => true,
      'multiple'   => false,
      'sql'        => $sql,
      'parameters' => [
        'process_id' => $id
      ]
    ]);

    $this->commit();

    if (!$dbProcess) return null;

    return $this->mapProcess($dbProcess);
  }

  public function createOrUpdate(Process $process): Process
  {
    $this->beginTransaction();

    $id = $process->getId();
    $name = $process->getName();
    $personId = $process->getPersonId();
    $unitId = $process->getUnitId();
    $statusId = $process->getStatusId();
    $queueActionId = $process->getQueueActionId();

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
        )";

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

    } else {
      $sql = 
        "UPDATE processes
        SET
            person_id = :new_person_id,
            unit_id = :new_unit_id,
            status_id = :new_status_id,
            queue_action_id = :new_queue_action_id,
            name = :new_name,
            updated_at = NOW()
        WHERE
            id = :process_id";

        $updated = $this->runSQL([
          'return'     => false,
          'multiple'   => false,
          'sql'        => $sql,
          'parameters' => [
            'new_person_id'       => $personId,
            'new_unit_id'         => $unitId,
            'new_status_id'       => $statusId,
            'new_queue_action_id' => $queueActionId,
            'new_name'            => $name,
            'process_id'          => $id
          ]
        ]);

        if (!$updated) {
          throw new DomainException('unable to make a call', 422);
        }

    }
    $this->commit();

    return $process;
  }

  public function removeById(int $id): bool | null
  {
    $this->beginTransaction();

    $sql = "DELETE FROM 
              processes p
            WHERE
              p.id = :process_id";

    $removed = $this->runSQL([
      'return'     => false,
      'multiple'   => false,
      'sql'        => $sql,
      'parameters' => [
        'process_id' => $id
      ]
    ]);

    if (!$removed) {
      throw new DomainException('unable to make a call', 422);
    }

    $this->commit();
    return $removed;
  }
}