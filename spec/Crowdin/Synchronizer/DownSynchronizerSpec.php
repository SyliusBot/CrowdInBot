<?php

namespace spec\SyliusBot\Crowdin\Synchronizer;

use PhpSpec\ObjectBehavior;

/**
 * @mixin \SyliusBot\Crowdin\Synchronizer\DownSynchronizer
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class DownSynchronizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Synchronizer\DownSynchronizer');
    }

//    function it_implements_TODO_interface()
//    {
//        $this->shouldImplement('SyliusBot\Crowdin\Synchronizer\DownSynchronizerInterface');
//    }
}
