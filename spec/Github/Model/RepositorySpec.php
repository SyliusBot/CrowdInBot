<?php

namespace spec\SyliusBot\Github\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin \SyliusBot\Github\Model\Repository
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class RepositorySpec extends ObjectBehavior
{
    function let($organization = 'SyliusBot', $name = 'Sylius')
    {
        $this->beConstructedWith($organization, $name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Github\Model\Repository');
    }

    function it_implements_Github_Repository_interface()
    {
        $this->shouldImplement('SyliusBot\Github\Model\RepositoryInterface');
    }

    function it_returns_organization($organization)
    {
        $this->getOrganization()->shouldReturn($organization);
    }

    function it_returns_name($name)
    {
        $this->getName()->shouldReturn($name);
    }
}
