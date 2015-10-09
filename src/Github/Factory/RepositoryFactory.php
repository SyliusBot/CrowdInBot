<?php


namespace SyliusBot\Github\Factory;

use SyliusBot\Github\Model\Repository;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class RepositoryFactory implements RepositoryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($organization, $name)
    {
        return new Repository($organization, $name);
    }

}
