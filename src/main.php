<?php

use VolkLms\Poc\Controllers\CreateProcessPageController;
use VolkLms\Poc\Controllers\IndexPageController;
use VolkLms\Poc\Web\Router;
use VolkLms\Poc\Controllers\ProcessesPageController;
use VolkLms\Poc\Controllers\SaveProcessController;
use VolkLms\Poc\Exceptions\BadRequestException;
use VolkLms\Poc\Web\Response;

try {
  $dbConfig = require ABS_PATH . '/src/Config/dbConfig.php';
  $host = $dbConfig['host']; 
  $port = $dbConfig['port'];
  $database = $dbConfig['dbname']; 
  $username = $dbConfig['user']; 
  $password = $dbConfig['password']; 

  $connect = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $router = new Router($connect);

  $router->get('/', IndexPageController::class);
  $router->get('processos', ProcessesPageController::class);
  $router->get('processos/cadastro', CreateProcessPageController::class);
  $router->post('processos/cadastro', SaveProcessController::class);

  $router->route();

} catch (Exception $error) {
  if ($error instanceof PDOException) {
    echo "database error: " . $error->getMessage();
  } elseif ($error instanceof BadRequestException) {
    Response::statusCode(400)::json([ 'message' => "error: " . $error->getMessage() ]);
  } elseif ($error instanceof DomainException) {
    Response::statusCode(401)::json([ 'message' => "error: " . $error->getMessage() ]);
  } else {
    Response::statusCode(500)::json([ 'message' => 'internal server error' ]);
    // var_dump($error->getMessage());
  }
}
exit;