<?php


namespace SyliusBot\TranslationTransformer\Handler;

use SyliusBot\TranslationTransformer\Event\TranslationEntryChangeEvent;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryCollectionHandler
{
    /**
     * @param TranslationEntryChangeEvent $translationEntryChangeEvent
     */
    public function modifyTranslationEntryCollectionDueToChanges(TranslationEntryChangeEvent $translationEntryChangeEvent)
    {
        $translationEntryCollection = $translationEntryChangeEvent->getTranslationEntryCollection();
        $translationEntryChange = $translationEntryChangeEvent->getTranslationEntryChange();

        $translationEntryCollection->remove($translationEntryChange->getOldTranslationEntry()->getKey());
        $translationEntryCollection->add($translationEntryChange->getNewTranslationEntry());
    }
}
