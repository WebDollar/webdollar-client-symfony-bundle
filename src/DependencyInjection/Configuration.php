<?php

namespace WebDollar\WebDollarClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Xterr\SupervisorBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('web_dollar_client');

        // Keep compatibility with symfony/config < 4.2
        if (!method_exists($treeBuilder, 'getRootNode'))
        {
            $rootNode = $treeBuilder->root('web_dollar_client');
        }
        else
        {
            $rootNode = $treeBuilder->getRootNode();
        }

        $this->configureClients($rootNode);

        return $treeBuilder;
    }

    private function configureClients(ArrayNodeDefinition $root)
    {
        $root->children()
            ->arrayNode('clients')
                ->useAttributeAsKey('name')
                ->prototype('array')
                ->validate()
                    ->ifTrue(function ($config) {
                        return !empty($config['service']) && !empty($config['config']);
                    })
                    ->thenInvalid('If you want to use the "service" key you cannot specify "config".')
                ->end()
                ->children()
                    ->scalarNode('service')
                        ->defaultNull()
                        ->info('The service id of the client to use.')
                    ->end()
                    ->variableNode('config')->defaultValue([])->end()
                ->end()
            ->end()
        ->end();
    }
}
