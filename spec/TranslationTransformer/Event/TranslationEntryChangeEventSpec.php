<?php

namespace spec\SyliusBot\TranslationTransformer\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationTransformer\Model\TranslationEntryChangeInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @mixin \SyliusBot\TranslationTransformer\Event\TranslationEntryChangeEvent
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryChangeEventSpec extends ObjectBehavior
{
    function let(TranslationEntryCollectionInterface $translationEntryCollection, TranslationEntryChangeInterface $translationEntryChange)
    {
        $this->beConstructedWith($translationEntryCollection, $translationEntryChange);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\Event\TranslationEntryChangeEvent');
    }

    function it_is_Symfony_Dispatcher_event()
    {
        $this->shouldHaveType(Event::class);
    }

    function it_has_a_collection_of_translation_entries(TranslationEntryCollectionInterface $translationEntryCollection)
    {
        $this->getTranslationEntryCollection()->shouldReturn($translationEntryCollection);
    }

    function it_has_translation_entry_change(TranslationEntryChangeInterface $translationEntryChange)
    {
        $this->getTranslationEntryChange()->shouldReturn($translationEntryChange);
    }
}
