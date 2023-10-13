<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Exceptions\BadGatewayException;
use VolkLms\Poc\Exceptions\NotFoundException;
use VolkLms\Poc\Exceptions\UnauthorizedException;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Models\QueueIntegration;
use VolkLms\Poc\Repositories\PDOProcessRepository;
use VolkLms\Poc\Services\ServiceClient;
use VolkLms\Poc\Web\Request;
use VolkLms\Poc\Web\Response;

class IntegrationVolkLMSController implements Controller 
{
  public function handle(Request $request, PDO $db) 
  {
    $processId = $request->getParam('processId');
    $repository = new PDOProcessRepository($db);
    $process = $repository->findById($processId);

    if (!$process) {
      throw new NotFoundException('unauthorized service');
    }

    // auth response schema
    // {
    //   "error": "",
    //   "result": {
    //       "user": "volklms@evolke.com.br",
    //       "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyaWQiOiIzIiwiaWF0IjoxNjk3MTM0MzA0LCJleHAiOjE2OTcxMzc5MDR9.UAjvZxouyG_uSkLr4wfVQ__8XQbX73kffjs92HiwvnA",
    //       "token_type": "bearer",
    //       "expires_in": 3600
    //   }
    // }
    $auth = ServiceClient::request([
      'url' => 'https://dev.evolke.com.br/admin/gabriel/evolke-admin/api/v2/router.php', 
      'method' => 'GET', 
      'queryParams' => [
        'action' => 'authToken',
        'email'  => 'volklms@evolke.com.br',
        'senha'  => 'volklmsdesafio'
      ]
    ]);
    if ($auth['error']) {
      throw new UnauthorizedException('unauthorized service');
    }

    $token = $auth['result']['access_token'];
    $queueId = $process->getQueueIntegrationId();

    if ($queueId) {
      // update queue response schema
      // {
      //     "error": "",
      //     "result": {
      //         "info": "Fila atualizada com sucesso",
      //         "tx_url": null
      //     }
      // }     
      $updateProcess = ServiceClient::request([
        'url' => 'https://dev.evolke.com.br/admin/gabriel/evolke-admin/api/v2/router.php', 
        'method' => 'GET', 
        'queryParams' => [
          'action'  => 'updateQueue',
          'id_fila' => $queueId,
          'status'  => $process->getStatusId(),
        ],
        'headers' => [
          'Authorization' => "Bearer {$token}"
        ]
      ]);
      if ($updateProcess['error']) {
        throw new BadGatewayException('integration error when updating');
      }

    } else {
      // new queue response schema
      // {
      //   "error": "",
      //   "result": {
      //      "info": "Fila criada com sucesso",
      //      "id_fila": "107"
      //   }
      // }      
      $newIntegrated = ServiceClient::request([
        'url' => 'https://dev.evolke.com.br/admin/gabriel/evolke-admin/api/v2/router.php', 
        'method' => 'GET', 
        'queryParams' => [
          'action'      => 'newQueue',
          'id_pessoa'   => $process->getPersonFullname(),
          'id_unidade'  => $process->getUnitNumber(),
          'status'      => $process->getUnitId(),
          'acao_fila'   => $process->getQueueActionId(),
        ],
        'headers' => [
          'Authorization' => "Bearer {$token}"
        ]
      ]);
      if ($newIntegrated['error']) {
        throw new BadGatewayException('integration error when registering');
      }

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

    // get queue response schema
    // {
    //   "error": "",
    //   "result": {
    //     "info": "Fila atualizada com sucesso",
    //     "data": [
    //       {
    //         "id": "1",
    //         "ds_nome": "Imp teste 1",
    //         "id_pessoa": "847061",
    //         "id_unidade_padrao": "1335",
    //         "status": "CANCELADO",
    //         "nr_acao": "0"
    //       }
    //     ]
    //   }
    // }
    $queueProcess = ServiceClient::request([
      'url' => 'https://dev.evolke.com.br/admin/gabriel/evolke-admin/api/v2/router.php', 
      'method' => 'GET', 
      'queryParams' => [
        'action'  => 'getQueue',
        'id_fila' => $queueId
      ],
      'headers' => [
        'Authorization' => "Bearer {$token}"
      ]
    ]);
    if ($queueProcess['error']) {
      throw new BadGatewayException('non-preprocessed service');
    }

    $queueProcess = $queueProcess['result']['data'];

    $integrateStatus = strtoupper(trim($queueProcess['status']));
    $processStatus = strtoupper(trim($process->getStatusDescription()));

    if ($integrateStatus === $processStatus) {
      throw new BadGatewayException('non-preprocessed service');
    }

    Response::statusCode(200)::json([ 'message' => 'ok' ]);
  }
}
