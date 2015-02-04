<?php

namespace Soil\EventBundle;

use Soil\EventBundle\DependencyInjection\Compiler\EventProcessorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SoilEventBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new EventProcessorCompilerPass());
    }
}
