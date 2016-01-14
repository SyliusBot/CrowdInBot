<?php

namespace SyliusBot\TranslationTransformer\Factory;

use SyliusBot\TranslationTransformer\Model\TranslationEntryCollection;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryCollectionFactory implements TranslationEntryCollectionFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($domain, array $translationEntries = [])
    {
        return new TranslationEntryCollection($domain, $translationEntries);
    }
}
