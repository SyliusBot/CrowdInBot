<?php

namespace SyliusBot\Github\Model;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface BranchInterface
{
    /**
     * @return RepositoryInterface
     */
    public function getRepository();

    /**
     * @return string
     */
    public function getName();
}
