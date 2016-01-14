<?php

namespace SyliusBot\TranslationTransformer\Factory;

use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationEntryCollectionFactoryInterface
{
    /**
     * @param string $domain
     * @param TranslationEntryInterface[] $translationEntries
     *
     * @return TranslationEntryCollectionInterface
     */
    public function create($domain, array $translationEntries = []);
}
