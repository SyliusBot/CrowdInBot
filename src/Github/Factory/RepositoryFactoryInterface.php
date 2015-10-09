<?php

namespace SyliusBot\Github\Factory;

use SyliusBot\Github\Model\RepositoryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface RepositoryFactoryInterface
{
    /**
     * @param string $organization
     * @param string $name
     *
     * @return RepositoryInterface
     */
    public function create($organization, $name);
}
