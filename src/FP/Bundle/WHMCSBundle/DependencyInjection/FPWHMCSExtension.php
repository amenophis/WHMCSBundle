<?php

/*
 * This file is part of the FP-WHMCSBunble
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FP\Bundle\WHMCSBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use FP\WHMCS\Adapter\Manager;
use FP\WHMCS\Adapter\Json\Connector;

/**
 * FPWHMCSExtension.
 * This enables us to add WHMCS connectivity through a service
 * @author Daniel Chalk <dan@french-property.com>
 */
class FPWHMCSExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
      $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
      $loader->load('services.yml');
      
      //always get the the last
      $config = end($configs);
      
      $container->setParameter('fp.whmcs.host', $config['host']);
      $container->setParameter('fp.whmcs.username', $config['username']);
      $container->setParameter('fp.whmcs.password', $config['password']);
      
      if(isset($config['connector']))
      {
        $container->setParameter('fp.whmcs.connector', $config['connector']);
      }

    }
    
    public function getAlias()
    {
      return 'fpwhmcs';
    }
}