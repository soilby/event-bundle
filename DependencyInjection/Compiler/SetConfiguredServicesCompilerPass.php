<?php
/**
 * Created by PhpStorm.
 * User: fliak
 * Date: 3.2.15
 * Time: 18.47
 */

namespace Soil\EventBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SetConfiguredServicesCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('soil_event_processor.processor_selector')) {
            return;
        }

        $eventLoggerDef = $container->getDefinition('soil_event.service.event_logger');

        $config = $container->getParameter('soil_event_config');

        $carrierServiceId = $config['carrier_config']['carrier_service'];
        if ($container->has($carrierServiceId)) {
            $reference = new Reference($carrierServiceId);
            $eventLoggerDef->addMethodCall('setLogCarrier', [$reference]);
        }

        $urinatorServiceId = $config['urinator_service'];
        if ($container->has($urinatorServiceId)) {
            $reference = new Reference($urinatorServiceId);
            $eventLoggerDef->addMethodCall('setUrinator', [$reference]);
        }

    }
} 