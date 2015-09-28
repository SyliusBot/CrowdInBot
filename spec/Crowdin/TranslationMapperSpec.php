<?php

namespace spec\SyliusBot\Crowdin;

use PhpSpec\ObjectBehavior;

/**
 * @mixin \SyliusBot\Crowdin\TranslationMapper
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationMapperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\TranslationMapper');
    }

//    function it_implements_TODO_interface()
//    {
//        $this->shouldImplement('SyliusBot\Crowdin\TranslationMapperInterface');
//    }
}
