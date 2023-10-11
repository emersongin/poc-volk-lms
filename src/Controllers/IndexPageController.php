<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Web\Request;

class IndexPageController implements Controller 
{
  public function handle(Request $request, PDO $db) 
  {

      echo json_encode($request);
  }
}
