<?php

namespace SyliusBot\Github\Factory;

use SyliusBot\Github\Model\BranchInterface;
use SyliusBot\Github\Model\RepositoryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface BranchFactoryInterface
{
    /**
     * @param RepositoryInterface $repository
     * @param string $name
     *
     * @return BranchInterface
     */
    public function create(RepositoryInterface $repository, $name);

    /**
     * @param RepositoryInterface $repository
     * @param string $name
     *
     * @return BranchInterface
     */
    public function createWithTimeSuffix(RepositoryInterface $repository, $name);
}
