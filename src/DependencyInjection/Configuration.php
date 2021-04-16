<?php
declare(strict_types=1);

namespace Landingi\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('landingi_api');
        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('pagination')
                    ->children()
                        ->scalarNode('default_limit')
                            ->defaultValue(10)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
