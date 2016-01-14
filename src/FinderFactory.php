<?php

namespace SyliusBot;

use Symfony\Component\Finder\Finder;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class FinderFactory implements FinderFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new Finder();
    }
}
