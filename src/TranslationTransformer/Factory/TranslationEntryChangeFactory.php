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

    /**
     * {@inheritdoc}
     */
    public function createFromString($string) {
        $translationEntryChangeRegexp = '/^MODIFY (.+) TO (.+)$/';

        if (false === (bool) preg_match($tecr, $string, $matches)) {
            throw new \InvalidArgumentException(sprintf(
                'Could not match "%s" by regular expression "%s"',
                $string,
                $translationEntryChangeRegexp
            ));
        }



    }
}
