<?php

namespace spec\SyliusBot\TranslationTransformer\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin \SyliusBot\TranslationTransformer\Model\TranslationEntry
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntrySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('translation.key', 'Translation value');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\Model\TranslationEntry');
    }

    function it_implements_Translation_Entry_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\Model\TranslationEntryInterface');
    }

    function it_has_key()
    {
        $this->getKey()->shouldReturn('translation.key');
    }

    function it_has_value()
    {
        $this->getValue()->shouldReturn('Translation value');
    }
}
