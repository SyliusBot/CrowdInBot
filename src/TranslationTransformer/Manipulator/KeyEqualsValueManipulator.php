<?php

namespace SyliusBot\TranslationTransformer\Manipulator;

use SyliusBot\TranslationTransformer\Factory\TranslationEntryChangeFactoryInterface;
use SyliusBot\TranslationTransformer\Factory\TranslationEntryFactoryInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use SyliusBot\TranslationTransformer\TranslationManipulatorInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class KeyEqualsValueManipulator implements TranslationManipulatorInterface
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
            $unifiedValue = strtolower(str_replace(' ', '[\s\._]*', preg_quote($translationEntry->getValue(), '/')));
            $unifiedValueMatcher = "/$unifiedValue/i";

            $keyParts = array_reverse(explode('.', $translationEntry->getKey()));

            $lastKeyParts = '';
            foreach ($keyParts as $keyPart) {
                if (empty($lastKeyParts)) {
                    $lastKeyParts = $keyPart;
                } else {
                    $lastKeyParts = $keyPart . '.' . $lastKeyParts;
                }

                $lastKeyParts = strtolower($lastKeyParts);

                if (!preg_match($unifiedValueMatcher, $lastKeyParts)) {
                    continue;
                }

                $newTranslationEntry = $this->translationEntryFactory->create(
                    'sylius.ui.' . str_replace('.', '_', $lastKeyParts),
                    $translationEntry->getValue()
                );

                if ($newTranslationEntry->getKey() === $translationEntry->getKey()) {
                    break;
                }

                $translationEntriesChanges[] = $this->translationEntryChangeFactory->create(
                    $translationEntry,
                    $newTranslationEntry
                );

                break;
            }
        }

        return $translationEntriesChanges;
    }
}
