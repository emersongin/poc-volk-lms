<?php

namespace VolkLms\Poc\Views\Pages\CreateProcessPageView;

use VolkLms\Poc\Views\Pages\Page;

class CreateProcessPageView extends Page {
  private string $templateLocalPath = ABS_PATH . '/src/views/Pages/CreateProcessPageView/templates';

  private function renderPersonSelectOptions(array $persons)
  {
    $options = '';
    if(count($persons)) {
      foreach ($persons as $key => $person) {
        $options .= "<option value='{$person['id']}'>{$person['fullname']}</option>";
      }
    }
    return $options;
  }

  private function renderUnitSelectOptions(array $units)
  {
    $options = '';
    if(count($units)) {
      foreach ($units as $key => $unit) {
        $options .= "<option value='{$unit['id']}'>{$unit['number']}</option>";
      }
    }
    return $options;
  }

  private function renderStatusSelectOptions(array $status)
  {
    $options = '';
    if(count($status)) {
      foreach ($status as $key => $state) {
        $options .= "<option value='{$state['id']}'>{$state['description']}</option>";
      }
    }
    return $options;
  }

  private function renderActionSelectOptions(array $status)
  {
    $options = '';
    if(count($status)) {
      foreach ($status as $key => $state) {
        $options .= "<option value='{$state['id']}'>{$state['description']}</option>";
      }
    }
    return $options;
  }

  public function output(array $data) 
  {
    $headerTitle = 'Fila de processos';

    $pageHeader = $this->renderTemplate($this->templateGlobalPath . '/header.php', [
      'headerTitle' => $headerTitle
    ]);

    $breadcrumb = file_get_contents($this->templateLocalPath . '/breadcrumb.php');
    $header = $this->renderTemplate($this->templateLocalPath . '/header.php', [
      'breadcrumb' => $breadcrumb,
      'integration' => ''
    ]);

    $personOptions = $this->renderPersonSelectOptions($data['persons']);
    $unitOptions = $this->renderUnitSelectOptions($data['units']);
    $statusOptions = $this->renderStatusSelectOptions($data['status']);
    $queueActionOptions = $this->renderActionSelectOptions($data['actions']);

    $form = file_get_contents($this->templateLocalPath . '/form.php');
    $content = $this->renderTemplate($this->templateLocalPath . '/content.php', [
      'form' => $form,
      'personOptions' => $personOptions,
      'unitOptions' => $unitOptions,
      'statusOptions' => $statusOptions,
      'queueActionOptions' => $queueActionOptions,
    ]);

    $body = file_get_contents($this->templateGlobalPath . '/body.php');

    $page[] = $pageHeader;
    $page[] = $header;
    $page[] = $content;
    $page[] = $body;

    return implode($page);
  }
}
