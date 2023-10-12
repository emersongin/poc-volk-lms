<?php

namespace VolkLms\Poc\Views\Pages;

abstract class Page
{
  protected string $templateGlobalPath = ABS_PATH . '/src/Views/templates';

  function renderTemplate($templateFile, $data) {
    if (file_exists($templateFile)) {
      $templateContent = file_get_contents($templateFile);

      foreach ($data as $key => $value) {
          $placeholder = '{{' . $key . '}}';
          $templateContent = str_replace($placeholder, $value, $templateContent);
      }

      return $templateContent;
    } 
    return "template file not found.";
  }
}