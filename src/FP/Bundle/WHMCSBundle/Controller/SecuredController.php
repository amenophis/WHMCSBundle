<?php

/*
 * This file is part of the FPWHMCSBundle
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FP\Bundle\WHMCSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * SecuredController
 * Use this for testing authentication
 * @author Daniel Chalk <dan@french-property.com>
 */
class SecuredController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('FPWHMCSBundle:Secured:index.html.twig');
    }
}
