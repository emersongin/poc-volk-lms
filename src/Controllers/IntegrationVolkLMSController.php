<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Exceptions\BadGatewayException;
use VolkLms\Poc\Exceptions\NotFoundException;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Models\QueueIntegration;
use VolkLms\Poc\Repositories\PDOProcessRepository;
use VolkLms\Poc\Services\ClientIntegrationQueueService;
use VolkLms\Poc\Web\Request;
use VolkLms\Poc\Web\Response;

class IntegrationVolkLMSController implements Controller 
{
  public function handle(Request $request, PDO $db) 
  {
    $processId = $request->getParam('processId');
    $repository = new PDOProcessRepository($db);
    $client = new ClientIntegrationQueueService();
    $process = $repository->findById($processId);

    if (!$process) {
      throw new NotFoundException('unauthorized service');
    }

    $email = 'volklms@evolke.com.br';
    $password = 'volklmsdesafio';
    $auth = $client->authToken($email, $password);

    $token = $auth['result']['access_token'];
    $client->setToken($token);
    $queueId = $process->getQueueIntegrationId();

    if ($queueId) {   
      $client->updateQueue($queueId, $process->getStatusId());

    } else {     
      $newIntegrated = $client->newQueue([
        'fullname'      => $process->getPersonFullname(),
        'unitNumber'    => $process->getUnitNumber(),
        'status'        => $process->getStatus(),
        'queueActionId' => $process->getQueueActionId(),
      ]);
      $queueId = $newIntegrated['result']['id_fila'];

      $integratedProcess = Process::createProcessWithQueueIntegration([
        'id'               => $process->getId(),
        'name'             => $process->getName(),
        'person'           => $process->getPerson(),
        'status'           => $process->getStatus(),
        'unit'             => $process->getUnit(),
        'queueAction'      => $process->getQueueAction(),
        'createdAt'        => $process->getCreatedAt(),
        'updatedAt'        => $process->getUpdatedAt(),
        'queueIntegration' => new QueueIntegration(
          $queueId,
          $process->getStatusId(),
          $process->getQueueActionId(),
          $process->getUpdatedAt()
        )
      ]);

      $integratedProcess = $repository->createOrUpdate($integratedProcess);

    }

    $queueProcess = $client->getQueue($queueId);
    $queueProcess = $queueProcess['result']['data'];

    $integrateStatus = strtoupper(trim($queueProcess['status']));
    $processStatus = strtoupper(trim($process->getStatusDescription()));

    if ($integrateStatus === $processStatus) {
      throw new BadGatewayException('non-preprocessed service');
    }

    Response::statusCode(200)::json([ 'message' => 'ok' ]);
  }
}
