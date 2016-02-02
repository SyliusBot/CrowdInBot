<?php

namespace SyliusBot\TranslationTransformer\Factory;

use SyliusBot\TranslationTransformer\Model\TranslationEntryChangeInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationEntryChangeFactoryInterface
{
    /**
     * @param TranslationEntryInterface $oldTranslationEntry
     * @param TranslationEntryInterface $newTranslationEntry
     *
     * @return TranslationEntryChangeInterface
     */
    public function create(TranslationEntryInterface $oldTranslationEntry, TranslationEntryInterface $newTranslationEntry);

    /**
     * @param string $string
     *
     * @return TranslationEntryChangeInterface
     */
    public function createFromString($string);
}
