<?php

namespace SyliusBot\Crowdin\Scheduler;

use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class CompositeSynchronizationScheduler implements SynchronizationSchedulerInterface
{
    /**
     * @var SynchronizationSchedulerInterface[]
     */
    private $synchronizationSchedulers;

    /**
     * @param array $synchronizationSchedulers
     */
    public function __construct(array $synchronizationSchedulers = [])
    {
        $this->synchronizationSchedulers = $synchronizationSchedulers;
    }

    /**
     * {@inheritdoc}
     */
    public function schedule(TranslationProviderInterface $localTranslationProvider, TranslationProviderInterface $crowdinTranslationProvider)
    {
        $commands = [];
        foreach ($this->synchronizationSchedulers as $synchronizationScheduler) {
            $commands = array_merge(
                $commands,
                $synchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider)
            );
        }

        return $commands;
    }
}
