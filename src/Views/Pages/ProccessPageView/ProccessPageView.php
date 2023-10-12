<?php

namespace VolkLms\Poc\Views\Pages\ProccessPageView;

use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Views\Pages\Page;

class ProccessPageView extends Page {
  private string $templateLocalPath = ABS_PATH . '/src/views/Pages/ProccessPageView/templates';

  private function createTableRow(Process $process)
  {
    return $this->renderTemplate($this->templateLocalPath . '/row.php', [
      'id'        => $process->getId(),
      'name'      => $process->getName(),
      'person'    => $process->getPersonFullname(),
      'unit'      => $process->getUnitNumber(),
      'status'    => $process->getStatusDescription(),
      'createdAt' => $process->getCreatedAt(),
      'updatedAt' => $process->getUpdatedAt()
    ]);
  }

  private function createPagination(array $params)
  {
    $totalPages = $params['totalPages'];
    $currentPage = $params['currentPage'];
    $searchParam = $params['searchParam'];

    $visiblePages = 2;
    $startPage = max(1, $currentPage - $visiblePages);
    $endPage = min($totalPages, $currentPage + $visiblePages);

    $pagination = [];

    $disabled = ($currentPage <= 1) ? 'disabled' : '';
    $pagination[] = 
      '<li class="page-item '.$disabled.'">
        <a class="page-link" href="?page=1&search='.$searchParam.'">Primeira</a>
      </li>';

    $previusPage = ($currentPage - 1);
    $url = ($currentPage > 1) ? "?page={$previusPage}&search={$searchParam}" : '';
    $pagination[] = 
      '<li class="page-item '.$disabled.'">
        <a class="page-link" href="'.$url.'">Anterior</a>
      </li>';

    for ($page = $startPage; $page <= $endPage; $page++) {
        $label = $page;
        $url = "?page={$page}&search={$searchParam}";
        $active = ($page == $currentPage) ? 'active': '';
        $disabled = ($page == $currentPage);
        $pagination[] = 
          '<li class="'.$active.' page-item">
            <a class="page-link" '.($disabled ? '' : 'href="'.$url).'">'.$label.'</a>
          </li>';
    }

    $nextPage = ($currentPage + 1);
    $url = ($currentPage < $totalPages) ? "?page={$nextPage}&search={$searchParam}" : '';
    $disabled = ($currentPage >= $totalPages) ? 'disabled' : '';
    $pagination[] = 
      '<li class="page-item '.$disabled.'">
        <a class="page-link" href="'.$url.'">Próxima</a>
      </li>';

    $url = ($currentPage < $totalPages) ? "?page={$totalPages}&search={$searchParam}" : '';
    $pagination[] = 
      '<li class="page-item '.$disabled.'">
        <a class="page-link" href="'.$url.'">Última</a>
      </li>';

    return $pagination;
  }

  public function output(array $processes, array $params) {
    $headerTitle = 'Fila de processos';
    $styles = '<link rel="stylesheet" href="/css/table.css">';
    $pageHeader = $this->renderTemplate($this->templateGlobalPath . '/header.php', [
      'headerTitle' => $headerTitle,
      'styles' => $styles
    ]);

    $breadcrumb = file_get_contents($this->templateLocalPath . '/breadcrumb.php');
    $filterForm = file_get_contents($this->templateLocalPath . '/filter-form.php');
    $registerButton = file_get_contents($this->templateLocalPath . '/button.php');
    $header = $this->renderTemplate($this->templateLocalPath . '/header.php', [
      'breadcrumb'    => $breadcrumb,
      'filterForm'    => $filterForm,
      'searchValue'   => $params['searchValue'],
      'createButton'  => $registerButton
    ]);

    $rows = implode(array_map([$this, 'createTableRow'], $processes));
    $paginationLinks = implode($this->createPagination($params));

    $table = file_get_contents($this->templateLocalPath . '/table.php');
    $pagination = file_get_contents($this->templateLocalPath . '/pagination.php');
    $content = $this->renderTemplate($this->templateLocalPath . '/content.php', [
      'table'      => $table,
      'rows'       => count($processes) ? $rows : '<tr><td colspan="8">nenhum resultado foi encontrado.</td></tr>',
      'pagination' => $pagination,
      'links'      => $paginationLinks
    ]);

    $scripts = '<script type="module" src="/js/remove-process-script.js"></script>';
    $body = $this->renderTemplate($this->templateGlobalPath . '/body.php', [
      'scripts' => $scripts,
    ]);

    $page[] = $pageHeader;
    $page[] = $header;
    $page[] = $content;
    $page[] = $body;

    return implode($page);
  }
}
