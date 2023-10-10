<?php

namespace VolkLms\Poc\Models;

class IntegrationQueue 
{
  private int $queueId;
  private int $actionNumber;

  public function __construct(int $queueId, int $actionNumber) 
  {
    $this->queueId = $queueId;
    $this->actionNumber = $actionNumber;
  }

  public function getQueueId(): int
  {
    return $this->queueId;
  }

  public function getActionNumber(): int
  {
    return $this->actionNumber;
  }
}