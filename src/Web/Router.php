<?php

namespace VolkLms\Poc\Web;

class Router {
    private $controllers = [];

    public function addController($route, $controller) {
        $this->controllers[$route] = $controller;
    }

    public function route() {
        $route = isset($_GET['action']) ? $_GET['action'] : (isset($_GET['page']) ? $_GET['page'] : 'default');

        if (array_key_exists($route, $this->controllers)) {
            $controller = $this->controllers[$route];
            $controllerInstance = new $controller();
            
            // Chama a função "handle" no controlador
            if (method_exists($controllerInstance, 'handle')) {
                $controllerInstance->handle();
            } else {
                echo "Função 'handle' não encontrada no controlador.";
            }
        } else {
            http_response_code(404);
            echo "Página não encontrada";
        }
    }
}