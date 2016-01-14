<?php

namespace spec\SyliusBot\TranslationTransformer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationTransformer\Event\TranslationEntryChangeEvent;
use SyliusBot\TranslationTransformer\Event\TranslationManipulationEvent;
use SyliusBot\TranslationTransformer\Model\TranslationEntryChangeInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollection;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use SyliusBot\TranslationTransformer\TranslationManipulatorInterface;
use SyliusBot\TranslationTransformer\TranslationTransformerEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @mixin \SyliusBot\TranslationTransformer\TranslationManipulator
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationManipulatorSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $eventDispatcher, TranslationManipulatorInterface $translationManipulator)
    {
        $this->beConstructedWith($eventDispatcher, [$translationManipulator]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\TranslationManipulator');
    }

    function it_implements_Translation_Manipulator_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\TranslationManipulatorInterface');
    }

    function it_throws_pre_and_post_manipulation_events(
        EventDispatcherInterface $eventDispatcher,
        TranslationEntryCollectionInterface $translationEntryCollection
    ) {
        $this->beConstructedWith($eventDispatcher, []);

        $eventDispatcher
            ->dispatch(
                TranslationTransformerEvents::PRE_MANIPULATION,
                Argument::type(TranslationManipulationEvent::class)
            )
            ->shouldBeCalled()
        ;

        $eventDispatcher
            ->dispatch(
                TranslationTransformerEvents::POST_MANIPULATION,
                Argument::type(TranslationManipulationEvent::class)
            )
            ->shouldBeCalled()
        ;

        $this->getTranslationEntriesChanges($translationEntryCollection)->shouldReturn([]);
    }

    function it_returns_translation_entries_changes_and_dispatches_them_as_an_event(
        EventDispatcherInterface $eventDispatcher,
        TranslationManipulatorInterface $translationManipulator,
        TranslationEntryCollectionInterface $translationEntryCollection,
        TranslationEntryChangeInterface $translationEntryChange
    ) {
        $eventDispatcher
            ->dispatch(
                TranslationTransformerEvents::PRE_MANIPULATION,
                Argument::type(TranslationManipulationEvent::class)
            )
            ->shouldBeCalled()
        ;

        $translationManipulator->getTranslationEntriesChanges($translationEntryCollection)->willReturn([$translationEntryChange]);

        $eventDispatcher
            ->dispatch(
                TranslationTransformerEvents::ENTRY_CHANGE,
                Argument::type(TranslationEntryChangeEvent::class)
            )
            ->shouldBeCalled()
        ;

        $eventDispatcher
            ->dispatch(
                TranslationTransformerEvents::POST_MANIPULATION,
                Argument::type(TranslationManipulationEvent::class)
            )
            ->shouldBeCalled()
        ;

        $this->getTranslationEntriesChanges($translationEntryCollection)->shouldReturn([$translationEntryChange]);
    }
}
