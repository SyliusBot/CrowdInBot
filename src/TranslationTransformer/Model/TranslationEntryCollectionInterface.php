<?php

namespace SyliusBot\TranslationTransformer\Model;

use Doctrine\Common\Collections\Collection;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationEntryCollectionInterface extends Collection
{
    /**
     * @param string $key
     *
     * @return TranslationEntryInterface|null
     */
    public function getByTranslationEntryKey($key);

    /**
     * @param string $value
     *
     * @return TranslationEntryInterface[]
     */
    public function getByTranslationEntryValue($value);

    /**
     * @return string
     */
    public function getDomain();
}
