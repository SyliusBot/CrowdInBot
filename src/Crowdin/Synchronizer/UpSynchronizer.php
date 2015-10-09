<?php

namespace SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use SyliusBot\Crowdin\TranslationProviderInterface;
use SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class UpSynchronizer implements SynchronizerInterface
{
    /**
     * @var SynchronizerInterface
     */
    private $gitSynchronizer;

    /**
     * @var TranslationProviderInterface
     */
    private $localTranslationProvider;

    /**
     * @var TranslationProviderInterface
     */
    private $crowdinTranslationProvider;

    /**
     * @var SynchronizationSchedulerInterface
     */
    private $upSynchronizationScheduler;

    /**
     * @param SynchronizerInterface $gitSynchronizer
     * @param TranslationProviderInterface $localTranslationProvider
     * @param TranslationProviderInterface $crowdinTranslationProvider
     * @param SynchronizationSchedulerInterface $upSynchronizationScheduler
     */
    public function __construct(
        SynchronizerInterface $gitSynchronizer,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        SynchronizationSchedulerInterface $upSynchronizationScheduler
    ) {
        $this->gitSynchronizer = $gitSynchronizer;
        $this->localTranslationProvider = $localTranslationProvider;
        $this->crowdinTranslationProvider = $crowdinTranslationProvider;
        $this->upSynchronizationScheduler = $upSynchronizationScheduler;
    }

    /**
     * {@inheritdoc}
     */
    public function synchronize()
    {
        $this->gitSynchronizer->synchronize();

        $commands = $this->upSynchronizationScheduler->schedule(
            $this->localTranslationProvider,
            $this->crowdinTranslationProvider
        );

        foreach ($commands as $command) {
            $command->execute();
        }
    }
}
