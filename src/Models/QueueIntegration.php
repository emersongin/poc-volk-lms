<?php

namespace VolkLms\Poc\Models;

class QueueIntegration 
{
  private int $queueId;
  private int $statusId;
  private int $actionId;
  private string $updatedAt = '';

  public function __construct(int $queueId, int $statusId, int $actionId, string $updatedAt) 
  {
    $this->queueId = $queueId;
    $this->statusId = $statusId;
    $this->actionId = $actionId;
    $this->updatedAt = date("d/m/Y H:i:s", strtotime($updatedAt ?? date("Y-m-d H:i:s")));
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

  public function getUpdatedAt(): string
  {
    return $this->updatedAt;
  }
}