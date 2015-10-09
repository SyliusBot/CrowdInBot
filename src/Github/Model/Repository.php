<?php

namespace SyliusBot\Github\Model;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class Repository implements RepositoryInterface
{
    /**
     * @var string
     */
    private $organization;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $organization
     * @param string $name
     */
    public function __construct($organization, $name)
    {
        $this->organization = $organization;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
}
