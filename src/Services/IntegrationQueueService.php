<?php

namespace VolkLms\Poc\Services;

interface IntegrationQueueService {
  function authToken(string $email, string $password): array;
  function getQueue(int $queueId): array;
  function newQueue(array $processDto): array;
  function updateQueue(int $queueId, string $status): array;
}