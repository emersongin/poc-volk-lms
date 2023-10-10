<?php

namespace VolkLms\Poc\Views;

use VolkLms\Poc\Models\Process;

class ProccessPageView {
  public function handle(Process $process) {
    $header = file_get_contents(ABS_PATH . '/src/views/templates/header.php');
    $body = file_get_contents(ABS_PATH . '/src/views/templates/body.php');

    $page[] = $header;
    $page[] = $process->getPersonFullname();
    $page[] = $body;

    return implode($page);
  }
}
