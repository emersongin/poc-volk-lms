<?php

namespace VolkLms\Poc\Views\Pages\ProccessPageView;

use VolkLms\Poc\Views\Pages\Page;

class ProccessPageView extends Page {
  private string $templateLocalPath = ABS_PATH . '/src/views/Pages/ProccessPageView/templates';

  public function output(array $persons) {
    $headerTitle = 'Fila de processos';

    $pageHeader = $this->renderTemplate($this->templateGlobalPath . '/header.php', [
      'headerTitle' => $headerTitle
    ]);

    $breadcrumb = file_get_contents($this->templateLocalPath . '/breadcrumb.php');
    $filterForm = file_get_contents($this->templateLocalPath . '/filter-form.php');
    $registerButton = file_get_contents($this->templateLocalPath . '/button.php');
    $header = $this->renderTemplate($this->templateLocalPath . '/header.php', [
      'breadcrumb' => $breadcrumb,
      'filterForm' => $filterForm,
      'createButton' => $registerButton
    ]);

    $table = file_get_contents($this->templateLocalPath . '/table.php');
    $pagination = file_get_contents($this->templateLocalPath . '/pagination.php');
    $content = $this->renderTemplate($this->templateLocalPath . '/content.php', [
      'table' => $table,
      'pagination' => $pagination
    ]);

    $body = file_get_contents($this->templateGlobalPath . '/body.php');

    $page[] = $pageHeader;
    $page[] = $header;
    $page[] = $content;
    $page[] = $body;

    return implode($page);
  }
}
