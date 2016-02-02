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
     * @param string|null $domain
     *
     * @return TranslationEntryInterface
     */
    public function create($key, $value, $domain);

    /**
     * @param string $string
     *
     * @return TranslationEntryInterface
     */
    public function createFromString($string);
}
