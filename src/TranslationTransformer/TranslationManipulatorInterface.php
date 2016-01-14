<?php

namespace SyliusBot\TranslationTransformer;

use SyliusBot\TranslationTransformer\Model\TranslationEntryChangeInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationManipulatorInterface
{
    /**
     * @param TranslationEntryCollectionInterface|TranslationEntryInterface[] $translationEntryCollection
     *
     * @return TranslationEntryChangeInterface[]
     */
    public function getTranslationEntriesChanges(TranslationEntryCollectionInterface $translationEntryCollection);
}
