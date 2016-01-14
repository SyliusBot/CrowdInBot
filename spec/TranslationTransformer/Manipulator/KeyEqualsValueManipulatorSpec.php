<?php

namespace spec\SyliusBot\TranslationTransformer\Manipulator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationTransformer\Factory\TranslationEntryChangeFactoryInterface;
use SyliusBot\TranslationTransformer\Factory\TranslationEntryFactoryInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryChangeInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @mixin \SyliusBot\TranslationTransformer\Manipulator\KeyEqualsValueManipulator
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class KeyEqualsValueManipulatorSpec extends ObjectBehavior
{
    function let(
        TranslationEntryFactoryInterface $translationEntryFactory,
        TranslationEntryChangeFactoryInterface $translationEntryChangeFactory
    ) {
        $this->beConstructedWith($translationEntryFactory, $translationEntryChangeFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\Manipulator\KeyEqualsValueManipulator');
    }

    function it_implements_Translation_Manipulator_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\TranslationManipulatorInterface');
    }

    function it_shortens_and_unifies_key_if_last_part_of_it_equals_its_value(
        TranslationEntryFactoryInterface $translationEntryFactory,
        TranslationEntryChangeFactoryInterface $translationEntryChangeFactory,
        TranslationEntryCollectionInterface $translationEntryCollection,
        TranslationEntryInterface $oldTranslationEntry,
        TranslationEntryInterface $newTranslationEntry,
        TranslationEntryChangeInterface $translationEntryChange,
        \Iterator $iterator
    )
    {
        $oldTranslationEntry->getKey()->willReturn('foo.bar.name');
        $oldTranslationEntry->getValue()->willReturn('Name');

        $translationEntryFactory->create('sylius.name', 'Name')->willReturn($newTranslationEntry);

        $newTranslationEntry->getKey()->willReturn('sylius.name');
        $newTranslationEntry->getValue()->willReturn('Name');

        $translationEntryChangeFactory->create($oldTranslationEntry, $newTranslationEntry)->willReturn($translationEntryChange);

        $translationEntryChange->getOldTranslationEntry()->willReturn($oldTranslationEntry);
        $translationEntryChange->getNewTranslationEntry()->willReturn($newTranslationEntry);

        $translationEntryCollection->getIterator()->willReturn($iterator);

        $iterator->rewind()->shouldBeCalled();
        $iterator->valid()->willReturn(true, false);
        $iterator->current()->willReturn($oldTranslationEntry);
        $iterator->next()->shouldBeCalled();

        $this->getTranslationEntriesChanges($translationEntryCollection)->shouldReturn([$translationEntryChange]);
    }
}
