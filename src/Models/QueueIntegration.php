<?php

namespace VolkLms\Poc\Models;

class QueueIntegration 
{
  private int $queueId;
  private int $statusId;
  private int $actionId;

  public function __construct(int $queueId, int $statusId, int $actionId) 
  {
    $this->queueId = $queueId;
    $this->statusId = $statusId;
    $this->actionId = $actionId;
  }

  public function getQueueId(): int
  {
    return $this->queueId;
  }

  public function getStatusId(): int
  {
    return $this->statusId;
  }

  public function getActionId(): int
  {
    return $this->actionId;
  }
}