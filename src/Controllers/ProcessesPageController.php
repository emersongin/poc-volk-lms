<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Repositories\PDOProcessRepository;
use VolkLms\Poc\Views\Pages\ProccessPageView\ProccessPageView;
use VolkLms\Poc\Web\Request;
use VolkLms\Poc\Web\Response;

class ProcessesPageController implements Controller 
{
  public function handle(Request $request, PDO $db) 
  {
    $processRepository = new PDOProcessRepository($db);

    $searchParam = $request->getParam('search') ?? '';
    $currentPage = $request->getParam('page') ?? 1;
    $take = $request->getParam('take') ?? 20;
    $skip = ($take * ($currentPage - 1));
    $totalItems = $processRepository->count([
      'searchParam' => $searchParam
    ]);
    $totalPages = ceil($totalItems / $take);

    $processes = $processRepository->findAll([
      'searchParam' => $searchParam,
      'offset'      => $skip,
      'limit'       => $take
    ]);
    $paginationParams = [
      'totalItems'  => $totalItems,
      'totalPages'  => $totalPages,
      'currentPage' => $currentPage,
      'searchParam' => $searchParam
    ];

    $page = new ProccessPageView();
    $output = $page->output($processes, $paginationParams);
    Response::statusCode(200)::html($output);
  }
}
