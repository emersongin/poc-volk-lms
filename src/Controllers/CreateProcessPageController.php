<?php

namespace VolkLms\Poc\Controllers;

use VolkLms\Poc\Web\Request;
use VolkLms\Poc\Web\Response;

class CreateProcessPageController implements Controller 
{
  public function handle(Request $request) 
  {

      // echo 'pagina de criação de processo';
      echo Response::statusCode(201)::json([]);
  }
}