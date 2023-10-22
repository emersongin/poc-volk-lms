<?php

namespace VolkLms\Poc\Services;

use VolkLms\Poc\Exceptions\BadGatewayException;
use VolkLms\Poc\Exceptions\UnauthorizedException;

class ClientIntegrationQueueService implements IntegrationQueueService {
  private string $token;

  function setToken(string $token)
  {
    $this->token = $token;
  }

  function authToken(string $email, string $password): array
  {
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
    return $auth;
  }

  function getQueue(int $queueId): array
  {
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
        'Authorization' => "Bearer {$this->token}"
      ]
    ]);
    if ($queueProcess['error']) {
      throw new BadGatewayException('non-preprocessed service');
    }
    return $queueProcess;
  }
  function newQueue(array $processDto): array
  {
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
        'id_pessoa'   => $processDto['fullname'],
        'id_unidade'  => $processDto['unitNumber'],
        'status'      => $processDto['unitId'],
        'acao_fila'   => $processDto['queueActionId']
      ],
      'headers' => [
        'Authorization' => "Bearer {$this->token}"
      ]
    ]);
    if ($newIntegrated['error']) {
      throw new BadGatewayException('integration error when registering');
    }
    return $newIntegrated;
  }
  function updateQueue(int $queueId, string $status): array
  {
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
        'status'  => $status,
      ],
      'headers' => [
        'Authorization' => "Bearer {$this->token}"
      ]
    ]);
    if ($updateProcess['error']) {
      throw new BadGatewayException('integration error when updating');
    }
    return $updateProcess;
  }
}