<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Exceptions\BadRequestException;
use VolkLms\Poc\Repositories\PDOProcessRepository;
use VolkLms\Poc\Web\Request;
use VolkLms\Poc\Web\Response;

class RemoveProcessController implements Controller 
{
  public function handle(Request $request, PDO $db) 
  {
    $id = $request->getParam('processId');

    if (!isset($id) || !is_numeric($id)) {
      throw new BadRequestException('process id is required');
    }

    $processRepository = new PDOProcessRepository($db);
    $processRepository->removeById($id);

    Response::statusCode(204);
  }
}
