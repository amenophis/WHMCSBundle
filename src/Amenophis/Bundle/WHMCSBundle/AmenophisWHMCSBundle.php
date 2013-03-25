<?php

/*
 * This file is part of the FPWHMCSBundle
 *
 * (c) IFP Ltd <support@french-property.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Amenophis\Bundle\WHMCSBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use FP\Bundle\WHMCSBundle\DependencyInjection\FPWHMCSExtension;

/**
 * AmenophisWHMCSBundle.
 *
 * @author Daniel Chalk <snathcfrigate@gmail.com>
 */
class AmenophisWHMCSBundle extends Bundle
{    
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // register extensions that do not follow the conventions manually
        $container->registerExtension(new AmenophisWHMCSExtension());
    }
}
