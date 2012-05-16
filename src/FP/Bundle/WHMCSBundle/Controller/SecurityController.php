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
use Symfony\Component\Security\Core\SecurityContext;

/**
 * SecurityController
 * @author Daniel Chalk <dan@french-property.com>
 */
class SecurityController extends Controller
{

  public function indexAction()
  {
    $request = $this->getRequest();
    $session = $request->getSession();

    // get the login error if there is one
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
    {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    }
    else
    {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }

    return $this->render('FPWHMCSBundle:Security:index.html.twig', array(
      'last_username' => $session->get(SecurityContext::LAST_USERNAME),
      'error' => $error,
    ));
  }

  public function signoutAction()
  {
    return $this->render('FPWHMCSBundle:Security:oops.html.twig');
  }

  public function checkAction()
  {
    return $this->render('FPWHMCSBundle:Security:oops.html.twig');
  }

}
