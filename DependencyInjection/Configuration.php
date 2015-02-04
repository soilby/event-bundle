<?php

namespace Soil\EventBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('soil_event');

        $rootNode
            ->children()
                ->arrayNode('ontology_config')
                    ->children()
                        ->scalarNode('ontology_uri')->isRequired()->end()
                        ->scalarNode('ontology_abbr')->isRequired()->end()
                        ->arrayNode('event_classification')
                            ->isRequired()
                            ->requiresAtLeastOneElement()
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('carrier_config')
                    ->children()
                        ->scalarNode('output_rdf_format')->defaultValue('ntriple')->end()
                        ->scalarNode('queue_stream_name')->defaultValue('soil_event')->end()
                        ->scalarNode('carrier_service')->defaultValue('soil_event.service.gearman_client')->end()
                    ->end()
                ->end()
                ->arrayNode('gearman')
                    ->children()
                        ->scalarNode('serverIP')->defaultValue('127.0.0.1')->end()
                        ->scalarNode('serverPort')->defaultValue(4730)->end()
                    ->end()
                ->end()
                ->scalarNode('urinator_service')->defaultValue('URInator')->end()
            ->end();






        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
