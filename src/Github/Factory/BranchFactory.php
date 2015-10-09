<?php


namespace SyliusBot\Github\Factory;

use SyliusBot\Github\Model\Branch;
use SyliusBot\Github\Model\RepositoryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class BranchFactory implements BranchFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(RepositoryInterface $repository, $name)
    {
        return new Branch($repository, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function createWithTimeSuffix(RepositoryInterface $repository, $name)
    {
        return $this->create($repository, $name . '-' . date('Y-m-d-H-i-s'));
    }
}
