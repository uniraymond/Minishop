<?php

namespace Minishop\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MinishopUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
