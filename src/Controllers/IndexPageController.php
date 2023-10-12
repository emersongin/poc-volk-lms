<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Repositories\PDOProcessRepository;
use VolkLms\Poc\Web\Request;
use VolkLms\Poc\Web\Response;

class IndexPageController implements Controller 
{
  public function handle(Request $request, PDO $db) 
  {
    // $processRepository = new PDOProcessRepository($db);
    // $searchParam = $request->getParam('searchParam') ?? '';
    // $currentPage = $request->getParam('currentPage') ?? 1;
    // $take = $request->getParam('take') ?? 20;
    // $skip = ($take * ($currentPage - 1));
    // $totalItems = $processRepository->count([
    //   'searchParam' => $searchParam
    // ]);
    // $totalPages = ceil($totalItems / $take);
    // $processes = $processRepository->findAll([
    //   'searchParam' => $searchParam,
    //   'offset'      => $skip,
    //   'limit'       => $take
    // ]);
    // $processDtos = array_map([$this, 'mapProcessDto'], $processes);
    // $headers = [
    //   'X-Total-Items'  => $totalItems,
    //   'X-Total-Pages'  => $totalPages,
    //   'X-Current-Page' => $currentPage
    // ];
    // Response::statusCode(200)::addHeaders($headers)::json($processDtos);

    header("Location: /processos");
  }

}
