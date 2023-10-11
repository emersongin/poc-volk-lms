<?php

namespace VolkLms\Poc\Web;

use PDO;

class Router {
  private $controllers = [];
  private PDO $db;

  public function __construct(PDO $db) {
    $this->db = $db;
  }

  public function addRoute($route, $controller) {
    $this->controllers[$route] = $controller;
  }

  public function route() {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = trim($uri, '/');

    if (empty($route)) {
      $route = '/';
    }

    if (array_key_exists($route, $this->controllers)) {
      $controller = $this->controllers[$route];
      $controllerInstance = new $controller();

      // Obter parâmetros da query string
      $queryParams = $_GET;

      // Obter parâmetros POST e, se a requisição for JSON, convertê-la em um array
      $postParams = ['body' => []]; // Inicialize com um array vazio

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $contentType = $_SERVER['HTTP_CONTENT_TYPE'];
        if (strpos($contentType, 'application/json') !== false) {
          // Requisição POST é JSON, então convertemos o corpo em um array
          $postBody = file_get_contents('php://input');
          $postParams['body'] = json_decode($postBody, true);
        } else {
          // Requisição POST não é JSON, usamos os parâmetros POST
          $postParams['body'] = $_POST;
        }
      }

      // Chama a função "handle" no controlador com os parâmetros separados
      if (method_exists($controllerInstance, 'handle')) {
        $controllerInstance->handle(new Request($queryParams, $postParams['body']), $this->db);
      } else {
        echo "Função 'handle' não encontrada no controlador.";
      }
    } else {
      http_response_code(404);
      echo "Página não encontrada";
    }
  }
}