<?php

namespace SyliusBot\TranslationTransformer\Event;

use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationManipulationEvent extends Event
{
    /**
     * @var TranslationEntryCollectionInterface
     */
    protected $translationEntryCollection;

    /**
     * @param TranslationEntryCollectionInterface $translationEntryCollection
     */
    public function __construct(TranslationEntryCollectionInterface $translationEntryCollection)
    {
        $this->translationEntryCollection = $translationEntryCollection;
    }

    /**
     * @return TranslationEntryCollectionInterface
     */
    public function getTranslationEntryCollection()
    {
        return $this->translationEntryCollection;
    }
}
