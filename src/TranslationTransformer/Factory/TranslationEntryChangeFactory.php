<?php

namespace SyliusBot\TranslationTransformer\Factory;

use SyliusBot\TranslationTransformer\Model\TranslationEntryChange;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryChangeFactory implements TranslationEntryChangeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(TranslationEntryInterface $oldTranslationEntry, TranslationEntryInterface $newTranslationEntry)
    {
        return new TranslationEntryChange($oldTranslationEntry, $newTranslationEntry);
    }
}
