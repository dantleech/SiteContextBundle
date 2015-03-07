<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Daniel Leech <daniel@dantleech.com>
 */
class SiteContextPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $this->registerResolvers($container);
        $this->registerProvider($container);
    }

    private function registerResolvers(ContainerBuilder $container)
    {
        $ids = $container->findTaggedServiceIds('cmf_site_context.resolver');
        $enabledResolvers = array_flip($container->getParameter('cmf_site_context.enabled_resolvers'));
        $resolverIds = array();

        foreach ($ids as $id => $attributes) {
            if (!isset($attributes[0]['alias'])) {
                throw new \InvalidArgumentException(sprintf(
                    'No "alias" specified for site context resolver "%s"',
                    $id
                ));
            }

            $alias = $attributes[0]['alias'];
            if (isset($enabledResolvers[$alias])) {
                $resolverIds[] = $id;
                unset($enabledResolvers[$alias]);
            }
        }

        if (count($enabledResolvers) > 0) {
            throw new RuntimeException(sprintf(
                'Unknown site context resolver(s): "%s"',
                implode('", "', array_keys($enabledResolvers))
            ));
        }

        if (count($resolverIds) === 1) {
            $container->setAlias('cmf_site_context.resolver', reset($resolverIds));
            return;
        }

        $chainResolver = $container->getDefinition('cmf_site_context.resolver.chain');

        $resolverRefs = array();
        foreach ($resolverIds as $resolverId) {
            $resolverRefs[] = new Reference($resolverId);
        }

        $chainResolver->replaceArgument(0, $resolverRefs);
        $container->setAlias('cmf_site_context.resolver', 'cmf_site_context.resolver.chain');
    }

    private function registerProvider(ContainerBuilder $container)
    {
        $ids = $container->findTaggedServiceIds('cmf_site_context.provider');
        $enabledProvider = $container->getParameter('cmf_site_context.enabled_provider');
        $providerId = null;
        $knownProviders = array();

        foreach ($ids as $id => $attributes) {
            if (!isset($attributes[0]['alias'])) {
                throw new \InvalidArgumentException(sprintf(
                    'No "alias" specified for site context provider "%s"',
                    $id
                ));
            }

            $alias = $attributes[0]['alias'];

            if ($alias === $enabledProvider) {
                $providerId = $id;
                break;
            }

            $knownProviders[] = $alias;
        }

        if (null === $providerId) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find provider with alias "%s", known providers: "%s"',
                $enabledProvider, implode('", "', $knownProviders)
            ));
        }

        $container->setAlias('cmf_site_context.provider', $providerId);
    }
}
