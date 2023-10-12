<?php

namespace VolkLms\Poc\Models;

class Process 
{
  private int $id = 0;
  private string $name;
  private Person $person;
  private Status $status;
  private Unit $unit;
  private QueueAction $queueAction;
  private IntegrationQueue $integrationQueue;
  private string $createdAt = '';
  private string $updatedAt = '';

  private function __construct(
    string $name,
    Person $person,
    Status $status,
    Unit $unit,
    QueueAction $queueAction,
    string | null $createdAt = null,
    string | null $updatedAt = null
  ) {
    $this->name = $name;
    $this->person = $person;
    $this->status = $status;
    $this->unit = $unit;
    $this->queueAction = $queueAction;
    $this->$createdAt = date("d/m/Y H:i:s", strtotime($createdAt ?? date("Y-m-d H:i:s")));
    $this->$updatedAt = date("d/m/Y H:i:s", strtotime($updatedAt ?? date("Y-m-d H:i:s")));
  }

  static public function createProcess($data): Process 
  {
    $process = new Process(
      $data['name'],
      $data['person'],
      $data['status'],
      $data['unit'],
      $data['queueAction'],
      $data['createdAt'] ?? null,
      $data['updatedAt'] ?? null
    );
    return $process;
  }

  static public function createProcessWithId($data): Process
  {
    $process = Process::createProcess($data);
    $process->id = $data['id']; 
    return $process;
  }

  static public function createProcessWithIntegrationQueue($data): Process
  {
    $process = Process::createProcessWithId($data);
    $process->integrationQueue = $data['integrationQueue']; 
    return $process;
  }

  static public function changeStatus(Process $process, int $statusId): Process
  {
    $process->status = new Status($statusId, '');
    return $process;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getPersonId(): int
  {
    return $this->person->getId();
  }

  public function getPersonFullname(): string
  {
    return $this->person->getFullname();
  }

  public function getStatusId(): int
  {
    return $this->status->getId();
  }

  public function getStatusDescription(): string
  {
    return $this->status->getDescription();
  }

  public function getUnitId(): int
  {
    return $this->unit->getId();
  }

  public function getUnitNumber(): string
  {
    return $this->unit->getNumber();
  }

  public function getQueueActionId(): int
  {
    return $this->queueAction->getId();
  }

  public function getQueueActionDescription(): string
  {
    return $this->queueAction->getDescription();
  }

  public function getIntegrationQueueId(): int
  {
    return $this->integrationQueue->getQueueId();
  }

  public function getIntegrationActionNumber(): int
  {
    return $this->integrationQueue->getActionNumber();
  }

  public function getCreatedAt(): string
  {
    return $this->createdAt;
  }

  public function getUpdatedAt(): string
  {
    return $this->updatedAt;
  }

}