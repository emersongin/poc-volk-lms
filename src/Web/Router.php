<?php

namespace VolkLms\Poc\Web;

use PDO;
use VolkLms\Poc\Exceptions\NotFoundException;

class Router {
  private $getControllers = [];
  private $postControllers = [];
  private PDO $db;

  public function __construct(PDO $db) {
      $this->db = $db;
  }

  public function get($route, $controller) {
      $this->getControllers[$route] = $controller;
  }

  public function post($route, $controller) {
      $this->postControllers[$route] = $controller;
  }

  public function route() {
      $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $route = trim($uri, '/');

      if (empty($route)) {
          $route = '/';
      }

      $method = $_SERVER['REQUEST_METHOD'];

      $publicPath = __DIR__ . '/public/' . $route;

      if (file_exists($publicPath) && is_file($publicPath)) {
          // Serve the static file directly
          header("Content-Type: " . mime_content_type($publicPath));
          readfile($publicPath);
      } else {
          if ($method === 'GET' && array_key_exists($route, $this->getControllers)) {
              $controller = $this->getControllers[$route];
          } elseif ($method === 'POST' && array_key_exists($route, $this->postControllers)) {
              $controller = $this->postControllers[$route];
          } else {
              throw new NotFoundException("not found");
          }

          $controllerInstance = new $controller();

          // Get query string parameters
          $queryParams = $_GET;

          // Get POST parameters and, if the request is JSON, convert it to an array
          $postParams = ['body' => []]; // Initialize with an empty array

          if ($method === 'POST') {
              $contentType = $_SERVER['HTTP_CONTENT_TYPE'];
              if (strpos($contentType, 'application/json') !== false) {
                  // POST request is JSON, so we convert the body to an array
                  $postBody = file_get_contents('php://input');
                  $postParams['body'] = json_decode($postBody, true);
              } else {
                  // POST request is not JSON, use POST parameters
                  $postParams['body'] = $_POST;
              }
          }

          // Call the "handle" function in the controller with the separated parameters
          if (method_exists($controllerInstance, 'handle')) {
              $controllerInstance->handle(new Request($queryParams, $postParams['body']), $this->db);
          } else {
              echo "Function 'handle' not found in the controller.";
          }
      }
  }
}
