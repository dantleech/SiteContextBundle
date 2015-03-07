<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Symfony\Cmf\Bundle\SiteContextBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    /**
     * Returns the config tree builder.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('cmf_site_context')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('enabled_provider')
                    ->info('Site context provider, e.g. doctrine_phpcr_odm')
                    ->isRequired()
                ->end()
                ->arrayNode('enabled_resolvers')
                    ->info('List of enabled site context resolvers')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('providers')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('doctrine_phpcr_odm')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('hosts_path')
                                    ->info('Content repository path to hosts')
                                    ->defaultValue('/cmf/hosts')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('resolvers')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('default')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('default_host')
                                    ->info('Default host, e.g. mysite.com')
                                    ->defaultNull()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('query')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('query_parameter')
                                    ->info('Query parameter to use to determine the site context')
                                    ->defaultValue('_host')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
