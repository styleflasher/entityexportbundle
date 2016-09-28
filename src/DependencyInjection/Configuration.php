<?php

namespace Styleflasher\EntityExportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see
 * {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
/**
 * {@inheritdoc}
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('styleflasher_entity_export');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            ->children()
                ->arrayNode('groups')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->children()
                        ->arrayNode('entities')
                        //->useAttributeAsKey('entity')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('entity')->end()
                                ->scalarNode('locationId')->end()
                                ->arrayNode('storageDirs')
                                //->useAttributeAsKey('entity')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('field')->end()
                                        ->scalarNode('dir')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end() // groups
                ->end()
            ->end()
        ;


        return $treeBuilder;
    }
}
