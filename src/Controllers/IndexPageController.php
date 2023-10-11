<?php

namespace VolkLms\Poc\Controllers;

use VolkLms\Poc\Web\Request;

class IndexPageController implements Controller 
{
  public function handle(Request $request) 
  {

      echo json_encode($request);
  }
}
