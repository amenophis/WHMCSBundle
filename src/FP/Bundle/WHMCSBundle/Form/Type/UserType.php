<?php

/*
 * This file is part of the FP-WHMCSBunble
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace FP\Bundle\WHMCSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Use form type
 * @author Daniel Chalk <snathcfrigate@gmail.com>
 */
class UserType extends AbstractType
{

  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('email');

	//create the repeat password field
    $builder->add('password', 'repeated', array(
      'type' => 'password',
      'first_name' => "password",
      'second_name' => "password_again",
      'invalid_message' => "user.password.match"
    ));
  }

  public function getName()
  {
    return 'user';
  }

  public function getDefaultOptions()
  {
    return array('data_class' => 'FP\Bundle\WHMCSBundle\Entity\User', );
  }

}
