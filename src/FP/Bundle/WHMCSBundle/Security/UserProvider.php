<?php

/*
 * This file is part of the FP-WHMCSBunble
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


// src/Acme/WebserviceUserBundle/Security/User/WebserviceUserProvider.php
namespace FP\Bundle\WHMCSBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use FP\WHMCS\Adapter\Connector;
use FP\Bundle\WHMCSBundle\Security\User;

/**
 * User provider, retreives requested user accouns from WHMCS
 * @author Daniel Chalk <snathcfrigate@gmail.com>
 */
class UserProvider implements UserProviderInterface
{
  /**
   * @var FP\WHMCS\Adapter\Connector
   */
  protected $connector;
  
  /**
   * Constructor.
   *
   * The user array is a hash where the keys are usernames and the values are
   * an array of attributes: 'password', 'enabled', and 'roles'.
   *
   * @param array $users An array of users
   */
  public function __construct(Connector $connector)
  {
    $this->connector = $connector;
  }

  public function loadUserByUsername($username)
  {
    $response = $this->connector->execute('getclientsdetails', array('email' => $username));
    
    if($this->connector->is($response, Connector::SUCCESS))
    {
      //WHMCS stores the password and the salt together
      $password = explode(':', $response->password);
      $user = new User;
      $user->setUsername($response->email);
      $user->setPassword(current($password));
      $user->setSalt(end($password));
      $user->setRoles(array('ROLE_USER'));
      
      return $user;
    }
    
    throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
  }

  public function refreshUser(UserInterface $user)
  {
    if (!$user instanceof User)
    {
      throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
    }

    return $this->loadUserByUsername($user->getUsername());
  }

  public function supportsClass($class)
  {
    return $class === 'FP\Bundle\TestBundle\Entity\User';
  }

}
