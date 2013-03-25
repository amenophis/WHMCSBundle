<?php

/*
 * This file is part of the FPWHMCSBundle
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Amenophis\Bundle\WHMCSBundle\Security\Encoder;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Amenophis\WHMCS\Adapter\Connector;
use Amenophis\Bundle\WHMCSBundle\Entity\User;

/**
 * @author Daniel Chalk <snathcfrigate@gmail.com>
 */
class WHMCS implements PasswordEncoderInterface
{
  public function encodePassword($raw, $salt)
  {
    return md5($salt.$raw);
  }

  public function isPasswordValid($encoded, $raw, $salt)
  {
    return $encoded === $this->encodePassword($raw, $salt);
  }
}