<?php


namespace SyliusBot\TranslationTransformer\Factory;

use SyliusBot\TranslationTransformer\Model\TranslationEntry;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class TranslationEntryFactory implements TranslationEntryFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($key, $value)
    {
        return new TranslationEntry($key, $value);
    }
}
