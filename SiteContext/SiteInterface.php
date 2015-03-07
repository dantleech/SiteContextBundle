<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext;

/**
 * @author Daniel Leech <daniel@dantleech.com>
 */
interface SiteInterface
{
    /**
     * Return the public name of this site
     *
     * @return string
     */
    public function getName();
}

