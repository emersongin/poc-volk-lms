<?php

namespace VolkLms\Poc\Views\Pages\CreateProcessPageView;

use VolkLms\Poc\Models\Process;
use VolkLms\Poc\Views\Pages\Page;

class CreateProcessPageView extends Page {
  private string $templateLocalPath = ABS_PATH . '/src/views/Pages/CreateProcessPageView/templates';

  private function renderPersonSelectOptions(array $persons, int | null $id)
  {
    $options = '';
    if(count($persons)) {
      foreach ($persons as $key => $person) {
        $selected = $id == $person['id'] ? 'selected' : '';
        $options .= "<option value='{$person['id']}' {$selected}>{$person['fullname']}</option>";
      }
    }
    return $options;
  }

  private function renderUnitSelectOptions(array $units, int | null $id)
  {
    $options = '';
    if(count($units)) {
      foreach ($units as $key => $unit) {
        $selected = $id == $unit['id'] ? 'selected' : '';
        $options .= "<option value='{$unit['id']}' {$selected}>{$unit['number']}</option>";
      }
    }
    return $options;
  }

  private function renderStatusSelectOptions(array $status, int | null $id)
  {
    $options = '';
    if(count($status)) {
      foreach ($status as $key => $state) {
        $selected = $id == $state['id'] ? 'selected' : '';

        $options .= "<option value='{$state['id']}' {$selected}>{$state['description']}</option>";
      }
    }
    return $options;
  }

  private function renderActionSelectOptions(array $actions, int | null $id)
  {
    $options = '';
    if(count($actions)) {
      foreach ($actions as $key => $action) {
        $selected = $id == $action['id'] ? 'selected' : '';
        $options .= "<option value='{$action['id']}' {$selected}>{$action['description']}</option>";
      }
    }
    return $options;
  }

  public function output(array $data, Process | null $process) 
  {
    $processId = isset($process) ? $process->getId() : null;
    $processName = isset($process) ? $process->getName() : null;
    $processPersonId = isset($process) ? $process->getPersonId() : null;
    $processUnitId = isset($process) ? $process->getUnitId() : null;
    $processStatusId = isset($process) ? $process->getStatusId() : null;
    $processActionId = isset($process) ? $process->getQueueActionId() : null;

    $processUpdateAt = '';
    $integrationUpdateAt = '';

    if (isset($process)) {
      $processUpdateAt = $process->getUpdatedAt();
      $integrationUpdateAt = $process->getQueueIntegration() ? $process->getQueueIntegrationUpdatedAt() : null;
    }

    $headerTitle = 'Processo';
    $styles = '';
    $pageHeader = $this->renderTemplate($this->templateGlobalPath . '/header.php', [
      'headerTitle' => $headerTitle,
      'styles'      => $styles
    ]);

    $breadcrumb = file_get_contents($this->templateLocalPath . '/breadcrumb.php');
    $integrationButton = file_get_contents($this->templateLocalPath . '/integration-button.php');
    $header = $this->renderTemplate($this->templateLocalPath . '/header.php', [
      'breadcrumb'  => $breadcrumb,
      'integration' => $processUpdateAt !== $integrationUpdateAt ? $integrationButton : '',
      'processId'   => $processId ?? ''
    ]);

    $personOptions = $this->renderPersonSelectOptions($data['persons'], $processPersonId);
    $unitOptions = $this->renderUnitSelectOptions($data['units'], $processUnitId);
    $statusOptions = $this->renderStatusSelectOptions($data['status'], $processStatusId);
    $queueActionOptions = $this->renderActionSelectOptions($data['actions'], $processActionId);

    $form = file_get_contents($this->templateLocalPath . '/form.php');
    $content = $this->renderTemplate($this->templateLocalPath . '/content.php', [
      'form'               => $form,
      'processId'          => $processId ?? '',
      'name'               => $processName ?? '',
      'personOptions'      => $personOptions,
      'unitOptions'        => $unitOptions,
      'statusOptions'      => $statusOptions,
      'queueActionOptions' => $queueActionOptions,
      'disabled'           => $processId ? 'disabled' : ''
    ]);

    $scripts = '<script type="module" src="/js/integrate-process-script.js"></script>';
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