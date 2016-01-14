<?php

namespace SyliusBot\TranslationTransformer\Manipulator;

use SyliusBot\TranslationTransformer\Factory\TranslationEntryChangeFactoryInterface;
use SyliusBot\TranslationTransformer\Factory\TranslationEntryFactoryInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use SyliusBot\TranslationTransformer\TranslationManipulatorInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class InterpunctionCleanerManipulator implements TranslationManipulatorInterface
{
    /**
     * @var TranslationEntryFactoryInterface
     */
    private $translationEntryFactory;

    /**
     * @var TranslationEntryChangeFactoryInterface
     */
    private $translationEntryChangeFactory;

    /**
     * @param TranslationEntryFactoryInterface $translationEntryFactory
     * @param TranslationEntryChangeFactoryInterface $translationEntryChangeFactory
     */
    public function __construct(
        TranslationEntryFactoryInterface $translationEntryFactory,
        TranslationEntryChangeFactoryInterface $translationEntryChangeFactory
    ) {
        $this->translationEntryFactory = $translationEntryFactory;
        $this->translationEntryChangeFactory = $translationEntryChangeFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslationEntriesChanges(TranslationEntryCollectionInterface $translationEntryCollection)
    {
        $translationEntriesChanges = [];
        foreach ($translationEntryCollection as $translationEntry) {
            $originalValue = $translationEntry->getValue();
            $cleanedValue = ucfirst(preg_replace('/[:\s]+$/', '', $originalValue));

            if ($originalValue === $cleanedValue) {
                continue;
            }

            $translationEntriesChanges[] = $this->translationEntryChangeFactory->create(
                $translationEntry,
                $this->translationEntryFactory->create($translationEntry->getKey(), $cleanedValue)
            );
        }

        return $translationEntriesChanges;
    }
}
