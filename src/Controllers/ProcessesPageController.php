<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Models\Person;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Models\QueueAction;
use VolkLms\Poc\Models\Status;
use VolkLms\Poc\Models\Unit;
use VolkLms\Poc\Repositories\PDOProcessRepository;
use VolkLms\Poc\Views\Pages\ProccessPageView\ProccessPageView;
use VolkLms\Poc\Web\Request;
use VolkLms\Poc\Web\Response;

class ProcessesPageController implements Controller 
{
  public function handle(Request $request, PDO $db) {
      
    $processRepository = new PDOProcessRepository($db);

    $persons = $processRepository->all();
      // $process = Process::createProcess([
      //   'name' => 'novo processo',
      //   'person' => new Person(1, 'emerson andrey'),
      //   'status' => new Status(1, 'cancelado'),
      //   'unit' => new Unit(1, '11111'),
      //   'queueAction' => new QueueAction(1, 'algum nome')
      // ]);

      $page = new ProccessPageView();

      // Response::statusCode(200)::html($page->output($persons));
      Response::statusCode(200)::json($persons);
  }
}
