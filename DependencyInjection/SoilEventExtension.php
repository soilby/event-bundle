<?php

namespace Soil\EventBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SoilEventExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $eventLoggerDef = $container->getDefinition('soil_event.service.event_logger');
        $eventLoggerDef->addArgument($config['ontology_config']);
        $eventLoggerDef->addArgument($config['carrier_config']);

        $carrierServiceId = $config['carrier_config']['carrier_service'];
        $reference = new Reference($carrierServiceId);
        $eventLoggerDef->addMethodCall('setLogCarrier', [$reference]);

        $urinatorServiceId = $config['urinator_service'];
        $reference = new Reference($urinatorServiceId);
        $eventLoggerDef->addMethodCall('setUrinator', [$reference]);

    }
}
