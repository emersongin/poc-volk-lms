<?php

use VolkLms\Poc\Controllers\CreateProcessPageController;
use VolkLms\Poc\Controllers\EditProcessPageController;
use VolkLms\Poc\Controllers\IndexPageController;
use VolkLms\Poc\Web\Router;
use VolkLms\Poc\Controllers\ProcessesPageController;

$router = new Router();

$router->addController('/', IndexPageController::class);
$router->addController('processos', ProcessesPageController::class);
$router->addController('processos/cadastro', CreateProcessPageController::class);
$router->addController('processos/edicao', EditProcessPageController::class);

$router->route();
