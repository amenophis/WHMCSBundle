<?php

/*
 * This file is part of the FPWHMCSBundle
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amenophis\Bundle\WHMCSBundle\Entity;

use Amenophis\WHMCS\Adapter\Connector;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User.
 *
 * @Assert\Callback(methods = {"isUnique"})
 * @author Daniel Chalk <snathcfrigate@gmail.com>
 */
class User
{
  public function __construct(Connector $connector = null)
  {
    $this->_connector = $connector;
  }

  protected $id;

  /**
   * @Assert\Email(message = "user.email.invalid", checkMX = true)
   */
  protected $email; 

  /**
   * @Assert\MinLength(limit = 4, message = "user.password.to.short")
   */
  protected $password;

  public function getId()
  {
    return $this->id;
  }

  /**
   * Get email
   * @return string
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set email
   * @param string $email
   * @return Amenophis\Bundle\WHMCSBundle\Entity\User
   */
  public function setEmail($email)
  {
    $this->email = $email;
    return $this;
  }

  /**
   * Get password
   * @return string
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set password
   * @param string $password
   * @return Amenophis\Bundle\WHMCSBundle\Entity\User
   */
  public function setPassword($password)
  {
    $this->password = $password;
    return $this;
  }

  public function isUnique(ExecutionContext $context)
  {
    // UNIQUE ACCOUNT CHECK
    // somehow you have an array of "fake names"
    $query = $this->_connector->execute('getclients', array(
      'limitnum' => 1,
      'search' => $this->getEmail()
    ));

    if ($query->totalresults > 0)
    {
      $context->addViolationAtPath($context->getPropertyPath() . '.email', 'user.email.used', array(), true);
    }
  }

  /**
   * Authenticates the current client with WHMCS.
   */
  public function authenticate()
  {
    return $this->_connector->execute('validatelogin', array(
      'email' => $this->email,
      'password2' => $this->password
    ));
  }

  //Persists

  public function isNew()
  {
    return is_null($this->id) || $this->id < 1;
  }

  /**
   * This will sign the current user up. 
   * It is your responsibility to ensure the user is unique.
   */
  public function persist(Connector $connector = null)
  {
    if(is_null($connector))
        $connector = $this->_connector;

    if(is_null($connector))
        throw new \Exception('no connector available');

    if($this->isNew())
    {
      $response = $connector->execute('addclient', array(
        'password2' => $this->password,
        'email' => $this->email,
        'skipvalidation' => true
      ));

      if($connector->is($response, Connector::SUCCESS))
      {
        $this->id = $response->clientid;
        return true;
      }

      return false;
    }

    //this section handles users that are not new

    $response =  $this->_connector->execute('updateclient', array(
      'password2' => $this->password,
      'email' => $this->email,
      'skipvalidation' => true
    ));

    if($connector->is($response, Connector::SUCCESS))
    {
      $this->id = $response->clientid;
      return true;
    }

    return false;
  }

  public static function getInstance($values = null, Connector $connector)
  {
    if(is_null($values))
    {
      return new self($connector);
    }
    elseif(is_array($values) || is_object($values))
    {
      return self::makeInstance($values, $connector);
    }

    $data = $connector->execute('getclientsdetails', array('clientid' => $values));
    $client = new self($connector);

    print_r($data);exit;

  }

  public static function makeInstance($values = array(), Connector $connector = null)
  {
    $self = new self($connector);
    return $self->make($values);
  }

  public function make($values)
  {
    if(!is_array($values) && !is_object($values))
    {
      throw new \Exception('array or object expected');
    }

    foreach($values as $k => $v)
    {
      $this->$k = $v;
    }

    return $this;
  }
}
