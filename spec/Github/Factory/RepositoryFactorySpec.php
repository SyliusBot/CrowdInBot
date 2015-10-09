<?php

namespace spec\SyliusBot\Github\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Github\Model\RepositoryInterface;

/**
 * @mixin \SyliusBot\Github\Factory\RepositoryFactory
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class RepositoryFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Github\Factory\RepositoryFactory');
    }

    function it_implements_Repository_Factory_interface()
    {
        $this->shouldImplement('SyliusBot\Github\Factory\RepositoryFactoryInterface');
    }

    function it_creates_repository(RepositoryInterface $repository)
    {
        $repository->getOrganization()->willReturn('Organization');
        $repository->getName()->willReturn('RepositoryName');

        $this->create('Organization', 'RepositoryName')->shouldBeSameAs($repository);
    }

    public function getMatchers()
    {
        return [
            'beSameAs' => function ($subject, $expected) {
                return null !== $subject
                    && $subject->getOrganization() === $expected->getOrganization()
                    && $subject->getName() === $expected->getName()
                ;
            }
        ];
    }
}
