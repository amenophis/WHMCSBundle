<?php

/*
 * This file is part of the FPWHMCSBundle
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amenophis\Bundle\WHMCSBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Amenophis\WHMCS\Adapter\Manager;
use Amenophis\WHMCS\Adapter\Json\Connector;

/**
 * AmenophisWHMCSExtension.
 * This enables us to add WHMCS connectivity through a service
 * @author Daniel Chalk <dan@french-property.com>
 */
class AmenophisWHMCSExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
      $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
      $loader->load('services.yml');
      
      //always get the the last
      $config = end($configs);
      
      $container->setParameter('amenophis.whmcs.host', @$config['host']);
      $container->setParameter('amenophis.whmcs.username', @$config['username']);
      $container->setParameter('amenophis.whmcs.password', @$config['password']);
      
      if(isset($config['connector']))
      {
        $container->setParameter('amenophis.whmcs.connector', @$config['connector']);
      }
    }
    
    public function getAlias()
    {
      return 'amenophis_whmcs';
    }   
    
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fpwhmcs');

        $rootNode
            ->children()
                ->scalarNode('host')->defaultValue('')->end()
                ->scalarNode('username')->defaultValue('')->end()
                ->scalarNode('password')->defaultValue('')->end()
            ->end()
        ;
        return $treeBuilder;
    }
}