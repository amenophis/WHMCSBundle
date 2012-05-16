<?php

namespace FP\Bundle\WHMCSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SecuredController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('FPWHMCSBundle:Secured:index.html.twig');
    }
}
