<?php

namespace SyliusBot\Github\Model;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface RepositoryInterface
{
    /**
     * @return string
     */
    public function getOrganization();

    /**
     * @return string
     */
    public function getName();
}
