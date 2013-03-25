<?php

namespace Amenophis\Bundle\WHMCSBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;
/**
 * User that implements UserInterface
 * @author Daniel Chalk <snathcfrigate@gmail.com>
 */
class User implements UserInterface
{
	protected $roles;
	protected $username;
	protected $password;
	protected $salt; 
	
	public function __construct($username = null, $password = null, $roles = array(), $salt = null)
	{
		$this->setUsername($username)->setPassword($password)->setRoles($roles)->setSalt($salt);
	}
	
	public function setRoles($roles)
	{
		$this->roles = $roles;
		return $this;
	}
	
    public function getRoles()
	{
		return $this->roles;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}
	
    public function getPassword()
	{
		return $this->password;
	}
	
	public function setSalt($salt)
	{
		$this->salt = $salt;
		return $this;
	}
	
    public function getSalt()
	{
		return $this->salt;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}
	
    public function getUsername()
	{
		return $this->username;
	}
	
    public function eraseCredentials()
	{
		$this->setPassword(null);
	}
}
