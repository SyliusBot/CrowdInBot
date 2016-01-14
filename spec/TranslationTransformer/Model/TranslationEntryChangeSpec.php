<?php

namespace spec\SyliusBot\TranslationTransformer\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @mixin \SyliusBot\TranslationTransformer\Model\TranslationEntryChange
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryChangeSpec extends ObjectBehavior
{
    function let(TranslationEntryInterface $oldTranslationEntry, TranslationEntryInterface $newTranslationEntry)
    {
        $this->beConstructedWith($oldTranslationEntry, $newTranslationEntry);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\Model\TranslationEntryChange');
    }

    function it_implements_Translation_Entry_Change_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\Model\TranslationEntryChangeInterface');
    }

    function it_has_old_translation_entry(TranslationEntryInterface $oldTranslationEntry)
    {
        $this->getOldTranslationEntry()->shouldReturn($oldTranslationEntry);
    }

    function it_has_new_translation_entry(TranslationEntryInterface $newTranslationEntry)
    {
        $this->getNewTranslationEntry()->shouldReturn($newTranslationEntry);
    }
}
