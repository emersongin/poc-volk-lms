<?php

use VolkLms\Poc\Controllers\CreateProcessPageController;
use VolkLms\Poc\Controllers\IndexPageController;
use VolkLms\Poc\Web\Router;
use VolkLms\Poc\Controllers\ProcessesPageController;
use VolkLms\Poc\Controllers\SaveProcessController;

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

} catch (PDOException $e) {
  echo "Erro na conexão: " . $e->getMessage();
}
exit;