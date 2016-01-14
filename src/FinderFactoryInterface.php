<?php

namespace SyliusBot;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface FinderFactoryInterface
{
    /**
     * @return Finder|SplFileInfo[]
     */
    public function create();
}
