<?php

namespace spec\SyliusBot\Github\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Github\Model\RepositoryInterface;

/**
 * @mixin \SyliusBot\Github\Model\Branch
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class BranchSpec extends ObjectBehavior
{
    function let(RepositoryInterface $repository, $name = 'master')
    {
        $this->beConstructedWith($repository, $name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Github\Model\Branch');
    }

    function it_implements_Github_Branch_interface()
    {
        $this->shouldImplement('SyliusBot\Github\Model\BranchInterface');
    }

    function it_returns_repository(RepositoryInterface $repository)
    {
        $this->getRepository()->shouldReturn($repository);
    }

    function it_returns_name($name)
    {
        $this->getName()->shouldReturn($name);
    }
}
