<?php

use VolkLms\Poc\Controllers\CreateProcessPageController;
use VolkLms\Poc\Controllers\IndexPageController;
use VolkLms\Poc\Controllers\IntegrationVolkLMSController;
use VolkLms\Poc\Web\Router;
use VolkLms\Poc\Controllers\ProcessesPageController;
use VolkLms\Poc\Controllers\RemoveProcessController;
use VolkLms\Poc\Controllers\SaveProcessController;
use VolkLms\Poc\Exceptions\BadGatewayException;
use VolkLms\Poc\Exceptions\BadRequestException;
use VolkLms\Poc\Exceptions\DomainException;
use VolkLms\Poc\Exceptions\NotFoundException;
use VolkLms\Poc\Exceptions\UnauthorizedException;
use VolkLms\Poc\Web\Response;

// Configuração CORS - Permitindo qualquer origem (não seguro)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

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
  $router->post('processos/remover', RemoveProcessController::class);
  $router->post('processos/integracao', IntegrationVolkLMSController::class);

  $router->route();

} catch (Exception $error) {
  if ($error instanceof PDOException) {
    echo "databaseErroMessage: " . $error->getMessage();
  } elseif ($error instanceof BadRequestException) {
    Response::statusCode($error->getStatusCode())::json([ 'erroMessage' => $error->getMessage() ]);
  } elseif ($error instanceof UnauthorizedException) {
    Response::statusCode($error->getStatusCode())::json([ 'erroMessage' => $error->getMessage() ]);
  } elseif ($error instanceof DomainException) {
    Response::statusCode($error->getStatusCode())::json([ 'erroMessage' => $error->getMessage() ]);
  } elseif ($error instanceof NotFoundException) {
    Response::statusCode(404)::json([ 'erroMessage' => "404 not found" ]);
  } elseif ($error instanceof BadGatewayException) {
    Response::statusCode($error->getStatusCode())::json([ 'erroMessage' => $error->getMessage() ]);
  } else {
    Response::statusCode(500)::json([ 'erroMessage' => 'internal server error' ]);
  }
}
exit;