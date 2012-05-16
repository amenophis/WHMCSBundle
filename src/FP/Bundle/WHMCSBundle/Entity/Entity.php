<?php

/*
 * This file is part of the FP-WHMCSBunble
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FP\Bundle\WHMCSBundle\Entity;

use FP\Bundle\WHMCSBundle\Annotation;

/**
 * Enitity
 *
 * @author Daniel Chalk <snathcfrigate@gmail.com>
 */
class Entity
{
  private $_fields;
  private $_resources;

  public function __construct()
  {
    //dont use __CLASS__ as we want the name of the derived classes
    $class_name = get_class($this); //need to get the full class name

    $annotation = new Annotation(new \ReflectionClass($class_name));

    if($annotation->has('resources'))
    {
      $this->_resources = $annotation->get('resources');
    }
  }
}
