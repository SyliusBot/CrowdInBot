<?php

namespace SyliusBot\TranslationTransformer\Model;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationEntryChangeInterface
{
    /**
     * @return TranslationEntryInterface
     */
    public function getOldTranslationEntry();

    /**
     * @return TranslationEntryInterface
     */
    public function getNewTranslationEntry();
}
