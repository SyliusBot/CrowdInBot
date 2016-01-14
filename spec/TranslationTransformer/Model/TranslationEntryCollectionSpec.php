<?php

namespace spec\SyliusBot\TranslationTransformer\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin \SyliusBot\TranslationTransformer\Model\TranslationEntryCollection
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryCollectionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('messages');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\Model\TranslationEntryCollection');
    }

    function it_implements_Translation_Entry_Collection_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface');
    }
}
