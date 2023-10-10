<?php

use VolkLms\Poc\Web\Router;
use VolkLms\Poc\Controllers\ProcessesPageController;

$router = new Router();

$router->addController('processos', ProcessesPageController::class);

$router->route();
