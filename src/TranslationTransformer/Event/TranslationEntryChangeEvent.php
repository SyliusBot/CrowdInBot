<?php

namespace SyliusBot\TranslationTransformer\Event;

use SyliusBot\TranslationTransformer\Model\TranslationEntryChangeInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryChangeEvent extends Event
{
    /**
     * @var TranslationEntryCollectionInterface
     */
    protected $translationEntryCollection;

    /**
     * @var TranslationEntryChangeInterface
     */
    protected $translationEntryChange;

    /**
     * @param TranslationEntryCollectionInterface $translationEntryCollection
     * @param TranslationEntryChangeInterface $translationEntryChange
     */
    public function __construct(TranslationEntryCollectionInterface $translationEntryCollection, TranslationEntryChangeInterface $translationEntryChange)
    {
        $this->translationEntryCollection = $translationEntryCollection;
        $this->translationEntryChange = $translationEntryChange;
    }

    /**
     * @return TranslationEntryCollectionInterface
     */
    public function getTranslationEntryCollection()
    {
        return $this->translationEntryCollection;
    }

    /**
     * @return TranslationEntryChangeInterface
     */
    public function getTranslationEntryChange()
    {
        return $this->translationEntryChange;
    }
}
