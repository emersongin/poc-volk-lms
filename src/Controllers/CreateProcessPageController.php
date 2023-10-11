<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Repositories\PDOPersonRepository;
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
    $personRepository = new PDOPersonRepository($db);
    $unitRepository = new PDOUnitRepository($db);
    $statusRepository = new PDOStatusRepository($db);
    $queueActionRepository = new PDOQueueActionRepository($db);

    $persons =  $personRepository->all();
    $units =  $unitRepository->all();
    $status =  $statusRepository->all();
    $actions =  $queueActionRepository->all();

    $view = new CreateProcessPageView();
    $output = $view->output([
      'persons' => $persons,
      'units'   => $units,
      'status'  => $status,
      'actions' => $actions,
    ]);
    Response::statusCode(200)::html($output);
  }
}