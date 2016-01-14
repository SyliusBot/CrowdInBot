<?php


namespace SyliusBot\TranslationTransformer\Model;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class TranslationEntryChange implements TranslationEntryChangeInterface
{
    /**
     * @var TranslationEntryInterface
     */
    private $oldTranslationEntry;

    /**
     * @var TranslationEntryInterface
     */
    private $newTranslationEntry;

    /**
     * @param TranslationEntryInterface $oldTranslationEntry
     * @param TranslationEntryInterface $newTranslationEntry
     */
    public function __construct(TranslationEntryInterface $oldTranslationEntry, TranslationEntryInterface $newTranslationEntry)
    {
        $this->oldTranslationEntry = $oldTranslationEntry;
        $this->newTranslationEntry = $newTranslationEntry;
    }

    /**
     * {@inheritdoc}
     */
    public function getOldTranslationEntry()
    {
        return $this->oldTranslationEntry;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewTranslationEntry()
    {
        return $this->newTranslationEntry;
    }
}
