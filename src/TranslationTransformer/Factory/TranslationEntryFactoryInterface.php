<?php

namespace SyliusBot\TranslationTransformer\Factory;

use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationEntryFactoryInterface
{
    /**
     * @param string $key
     * @param string $value
     *
     * @return TranslationEntryInterface
     */
    public function create($key, $value);
}
