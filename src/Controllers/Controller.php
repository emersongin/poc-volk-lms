<?php

namespace VolkLms\Poc\Controllers;

use VolkLms\Poc\Web\Request;

interface Controller 
{
  public function handle(Request $requets);
}