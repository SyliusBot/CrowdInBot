<?php

namespace spec\SyliusBot;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin \SyliusBot\FinderFactory
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class FinderFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\FinderFactory');
    }

    function it_implements_Finder_Factory_interface()
    {
        $this->shouldImplement('SyliusBot\FinderFactoryInterface');
    }

    function it_creates_Finder()
    {
        $this->create()->shouldHaveType('Symfony\Component\Finder\Finder');
    }
}
