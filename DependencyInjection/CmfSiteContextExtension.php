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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

class CmfSiteContextExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $this->configureResolvers($config['resolvers'], $container);
        $this->configureProviders($config['providers'], $container);

        $enabledResolvers = $config['enabled_resolvers'];

        if (count($enabledResolvers) === 0) {
            throw new RuntimeException('You must enable at least one site context resolver');
        }

        $container->setParameter('cmf_site_context.enabled_resolvers', $enabledResolvers);
        $container->setParameter('cmf_site_context.enabled_provider', $config['enabled_provider']);

        $loader->load('site_context.xml');
    }

    private function configureResolvers($config, ContainerBuilder $container)
    {
        foreach ($config as $resolverAlias => $resolverConfig) {
            foreach ($resolverConfig as $key => $value) {
                $container->setParameter(sprintf(
                    'cmf_site_context.resolver.%s.%s',
                    $resolverAlias, $key
                ), $value);
            }
        }
    }

    private function configureProviders($config, ContainerBuilder $container)
    {
        foreach ($config as $providerAlias => $providerConfig) {
            foreach ($providerConfig as $key => $value) {
                $container->setParameter(sprintf(
                    'cmf_site_context.provider.%s.%s',
                    $providerAlias, $key
                ), $value);
            }
        }
    }
}
