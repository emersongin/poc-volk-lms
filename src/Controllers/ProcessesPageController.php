<?php

namespace VolkLms\Poc\Controllers;

use VolkLms\Poc\Models\Person;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Models\QueueAction;
use VolkLms\Poc\Models\Status;
use VolkLms\Poc\Models\Unit;
use VolkLms\Poc\Views\ProccessPageView;

class ProcessesPageController implements Controller 
{
  public function handle($request) {
      $page = new ProccessPageView();

      $process = Process::createProcess([
        'name' => 'novo processo',
        'person' => new Person(1, 'emerson andrey'),
        'status' => new Status(1, 'cancelado'),
        'unit' => new Unit(1, '11111'),
        'queueAction' => new QueueAction(1, 'algum nome')
      ]);

      echo $page->handle($process);
  }
}
