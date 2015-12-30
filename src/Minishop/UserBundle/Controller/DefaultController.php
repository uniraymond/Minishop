<?php

namespace Minishop\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

    public function indexAction()
    {
        return $this->render('MinishopUserBundle:Default:index.html.twig');
//        return array();
    }
}
