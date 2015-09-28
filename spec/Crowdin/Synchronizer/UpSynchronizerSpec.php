<?php

namespace spec\SyliusBot\Crowdin\Synchronizer;

use PhpSpec\ObjectBehavior;

/**
 * @mixin \SyliusBot\Crowdin\Synchronizer\UpSynchronizer
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class UpSynchronizerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Synchronizer\UpSynchronizer');
    }

//    function it_implements_TODO_interface()
//    {
//        $this->shouldImplement('SyliusBot\Crowdin\Synchronizer\UpSynchronizerInterface');
//    }
}
