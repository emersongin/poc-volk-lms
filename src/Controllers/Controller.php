<?php

namespace VolkLms\Poc\Controllers;

use PDO;
use VolkLms\Poc\Web\Request;

interface Controller 
{
  public function handle(Request $requets, PDO $db);
}