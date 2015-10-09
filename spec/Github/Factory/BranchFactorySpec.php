<?php

namespace spec\SyliusBot\Github\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Github\Model\BranchInterface;
use SyliusBot\Github\Model\RepositoryInterface;

/**
 * @mixin \SyliusBot\Github\Factory\BranchFactory
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class BranchFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Github\Factory\BranchFactory');
    }

    function it_implements_Branch_Factory_interface()
    {
        $this->shouldImplement('SyliusBot\Github\Factory\BranchFactoryInterface');
    }

    function it_creates_branch(RepositoryInterface $repository, BranchInterface $branch)
    {
        $branch->getRepository()->willReturn($repository);
        $branch->getName()->willReturn('BranchName');

        $this->create($repository, 'BranchName')->shouldBeSameAs($branch);
    }

    public function getMatchers()
    {
        return [
            'beSameAs' => function ($subject, $expected) {
                return null !== $subject
                    && $subject->getRepository() === $expected->getRepository()
                    && $subject->getName() === $expected->getName()
                ;
            }
        ];
    }
}
