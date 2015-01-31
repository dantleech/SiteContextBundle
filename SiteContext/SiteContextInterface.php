<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext;

/**
 * @author Daniel Leech <daniel@dantleech.com>
 */
class SiteContextInterface
{
    /**
     * Load the given Site into this site context
     *
     * @param SiteInterface $site
     */
    public function load(SiteInterface $site);

    /**
     * Return the loaded Site
     *
     * @return SiteInterface
     * @throws SiteNotLoadedException
     */
    public function getSite();
}

