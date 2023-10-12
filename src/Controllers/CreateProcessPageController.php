<?php

namespace VolkLms\Poc\Controllers;

use DomainException;
use PDO;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Repositories\PDOPersonRepository;
use VolkLms\Poc\Repositories\PDOProcessRepository;
use VolkLms\Poc\Repositories\PDOQueueActionRepository;
use VolkLms\Poc\Repositories\PDOStatusRepository;
use VolkLms\Poc\Repositories\PDOUnitRepository;
use VolkLms\Poc\Views\Pages\CreateProcessPageView\CreateProcessPageView;
use VolkLms\Poc\Web\Request;
use VolkLms\Poc\Web\Response;

class CreateProcessPageController implements Controller 
{
  public function handle(Request $request, PDO $db) 
  {
    $id = $request->getParam('processId');

    if (isset($id)) {
      $processRepository = new PDOProcessRepository($db);
      $process = $processRepository->findById($id);
    }

    $personRepository = new PDOPersonRepository($db);
    $unitRepository = new PDOUnitRepository($db);
    $statusRepository = new PDOStatusRepository($db);
    $queueActionRepository = new PDOQueueActionRepository($db);

    $persons =  $personRepository->findAll();
    $units =  $unitRepository->findAll();
    $status =  $statusRepository->findAll();
    $actions =  $queueActionRepository->findAll();

    $view = new CreateProcessPageView();
    $output = $view->output([
      'persons' => $persons,
      'units'   => $units,
      'status'  => $status,
      'actions' => $actions
    ], $process ?? null);
    
    Response::statusCode(200)::html($output);
  }
}