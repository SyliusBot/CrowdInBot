<?php

namespace SyliusBot\TranslationTransformer;

use SyliusBot\TranslationTransformer\Event\TranslationEntryChangeEvent;
use SyliusBot\TranslationTransformer\Event\TranslationManipulationEvent;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationManipulator implements TranslationManipulatorInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var TranslationManipulatorInterface[]
     */
    private $translationManipulators;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param TranslationManipulatorInterface[] $translationManipulators
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, array $translationManipulators = [])
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->translationManipulators = $translationManipulators;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslationEntriesChanges(TranslationEntryCollectionInterface $translationEntryCollection)
    {
        $registeredTranslationEntriesChanges = [];

        $this->eventDispatcher->dispatch(
            TranslationTransformerEvents::PRE_MANIPULATION,
            new TranslationManipulationEvent($translationEntryCollection)
        );

        foreach ($this->translationManipulators as $translationManipulator) {
            $translationEntriesChanges = $translationManipulator->getTranslationEntriesChanges($translationEntryCollection);
            foreach ($translationEntriesChanges as $translationEntryChange) {
                $registeredTranslationEntriesChanges[] = $translationEntryChange;

                $this->eventDispatcher->dispatch(
                    TranslationTransformerEvents::ENTRY_CHANGE,
                    new TranslationEntryChangeEvent($translationEntryCollection, $translationEntryChange)
                );
            }
        }

        $this->eventDispatcher->dispatch(
            TranslationTransformerEvents::POST_MANIPULATION,
            new TranslationManipulationEvent($translationEntryCollection)
        );

        return $registeredTranslationEntriesChanges;
    }
}
