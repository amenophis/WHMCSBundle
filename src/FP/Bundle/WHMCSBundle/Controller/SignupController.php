<?php

/*
 * This file is part of the FP-WHMCSBunble
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace FP\Bundle\WHMCSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
//these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FP\Bundle\WHMCSBundle\Entity\User;
use FP\Bundle\WHMCSBundle\Form\Type\UserType;
/**
 * SignupController.
 *
 * @author Daniel Chalk <snathcfrigate@gmail.com>
 */
class SignupController extends Controller
{
  /**
   * @Route("")
   */
  public function indexAction()
  {
    $whmcs = $this->get('fp.whmcs');
    $user = new User($whmcs);
    $form = $this->createForm(new UserType(), $user);
    return $this->render("FPWHMCSBundle:Signup:index.html.twig", array('form' => $form->createView(), ));
  }

  public function indexProcessAction()
  {
    $http_code = 200;

    $whmcs = $this->get('fp.whmcs');
    $user = new User($whmcs);
    $form = $this->createForm(new UserType(), $user);

    $form->bindRequest($this->getRequest());

    if ($form->isValid())
    {
      if ($user->persist())
      {
        $this->get('session')->set('new_account', $user);
        return $this->redirect($this->generateUrl('fp_whmcs_signup_success'));
      }
    }

    return $this->render("FPWHMCSBundle:Signup:index.html.twig", array('form' => $form->createView(), ));
  }

  public function completeAction()
  {
    return $this->render('FPWHMCSBundle:Signup:complete.html.twig', array('account' => $this->get('session')->get('new_account')));
  }

}
