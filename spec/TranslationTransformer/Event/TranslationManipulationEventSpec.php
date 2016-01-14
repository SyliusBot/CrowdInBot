<?php

namespace spec\SyliusBot\TranslationTransformer\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @mixin \SyliusBot\TranslationTransformer\Event\TranslationManipulationEvent
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationManipulationEventSpec extends ObjectBehavior
{
    function let(TranslationEntryCollectionInterface $translationEntryCollection)
    {
        $this->beConstructedWith($translationEntryCollection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\Event\TranslationManipulationEvent');
    }

    function it_is_Symfony_Dispatcher_event()
    {
        $this->shouldHaveType(Event::class);
    }

    function it_has_a_collection_of_translation_entries(TranslationEntryCollectionInterface $translationEntryCollection)
    {
        $this->getTranslationEntryCollection()->shouldReturn($translationEntryCollection);
    }
}
