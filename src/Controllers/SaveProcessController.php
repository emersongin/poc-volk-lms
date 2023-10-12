<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Exceptions\BadRequestException;
use VolkLms\Poc\Models\Person;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Models\QueueAction;
use VolkLms\Poc\Models\Status;
use VolkLms\Poc\Models\Unit;
use VolkLms\Poc\Repositories\PDOProcessRepository;
use VolkLms\Poc\Web\Request;

class SaveProcessController implements Controller 
{
  public function handle(Request $request, PDO $db) {
    $processId = $request->getParam('processId');
    $name = $request->getParam('name');
    $personId = $request->getParam('personId');
    $unitId = $request->getParam('unitId');
    $statusId = $request->getParam('statusId');
    $queueActionId = $request->getParam('queueActionId');

    $processRepository = new PDOProcessRepository($db);

    // updateing
    if ($processId) {
      if (!isset($statusId) || !is_numeric($statusId)) {
        throw new BadRequestException('process status id is required');
      }
      $process = $processRepository->findById($processId);
      $process = Process::changeStatus($process, $statusId);

    } else {
      // creating
      if (!isset($name) || !strlen($name)) {
        throw new BadRequestException('process name is required');
      }
      if (!isset($personId) || !is_numeric($personId)) {
        throw new BadRequestException('process person id is required');
      }
      if (!isset($unitId) || !is_numeric($unitId)) {
        throw new BadRequestException('process unit id is required');
      }
      if (!isset($statusId) || !is_numeric($statusId)) {
        throw new BadRequestException('process status id is required');
      }
      if (!isset($queueActionId) || !is_numeric($queueActionId)) {
        throw new BadRequestException('process queue action id is required');
      }

      $process = Process::createProcess([
        'name'        => $name,
        'person'      => new Person($personId, ''),
        'status'      => new Status($unitId, ''),
        'unit'        => new Unit($statusId, ''),
        'queueAction' => new QueueAction($queueActionId, '')
      ]);
    }

    $process = $processRepository->createOrUpdate($process);

    if ($process) {
      header("Location: /processos/cadastro?processId=" . $process->getId());
    }
  }
}
