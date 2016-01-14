<?php

namespace spec\SyliusBot\TranslationTransformer\Handler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationTransformer\Event\TranslationEntryChangeEvent;
use SyliusBot\TranslationTransformer\Model\TranslationEntryChangeInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @mixin \SyliusBot\TranslationTransformer\Handler\TranslationEntryCollectionHandler
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryCollectionHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\Handler\TranslationEntryCollectionHandler');
    }

    function it_modifies_translation_entry_collection_due_to_changes(
        TranslationEntryChangeEvent $translationEntryChangeEvent,
        TranslationEntryCollectionInterface $translationEntryCollection,
        TranslationEntryChangeInterface $translationEntryChange,
        TranslationEntryInterface $oldTranslationEntry,
        TranslationEntryInterface $newTranslationEntry
    ) {
        $translationEntryChangeEvent->getTranslationEntryCollection()->willReturn($translationEntryCollection);
        $translationEntryChangeEvent->getTranslationEntryChange()->willReturn($translationEntryChange);

        $translationEntryChange->getOldTranslationEntry()->willReturn($oldTranslationEntry);
        $translationEntryChange->getNewTranslationEntry()->willReturn($newTranslationEntry);

        $translationEntryCollection->removeElement($oldTranslationEntry)->shouldBeCalled();
        $translationEntryCollection->add($newTranslationEntry)->shouldBeCalled();

        $this->modifyTranslationEntryCollectionDueToChanges($translationEntryChangeEvent);
    }
}
