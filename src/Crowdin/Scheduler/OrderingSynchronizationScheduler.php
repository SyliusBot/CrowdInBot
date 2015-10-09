<?php


namespace SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class OrderingSynchronizationScheduler implements SynchronizationSchedulerInterface
{
    /**
     * @var SynchronizationSchedulerInterface
     */
    private $synchronizationScheduler;

    /**
     * @param SynchronizationSchedulerInterface $synchronizationScheduler
     */
    public function __construct(SynchronizationSchedulerInterface $synchronizationScheduler)
    {
        $this->synchronizationScheduler = $synchronizationScheduler;
    }

    /**
     * {@inheritdoc}
     */
    public function schedule(TranslationProviderInterface $localTranslationProvider, TranslationProviderInterface $crowdinTranslationProvider)
    {
        $commands = $this->synchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider);

        $addFileCommands = $updateFileCommands = $deleteFileCommands = [];
        $addDirectoryCommands = $deleteDirectoryCommands = [];
        foreach ($commands as $command) {
            switch(true) {
                case $command instanceof Api\AddFile:
                    $addFileCommands[] = $command;
                    break;
                case $command instanceof Api\UpdateFile:
                    $updateFileCommands[] = $command;
                    break;
                case $command instanceof Api\DeleteFile:
                    $deleteFileCommands[] = $command;
                    break;
                case $command instanceof Api\AddDirectory:
                    $addDirectoryCommands[] = $command;
                    break;
                case $command instanceof Api\DeleteDirectory:
                    $deleteDirectoryCommands[] = $command;
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf(
                       'Could not recognize "%s" command',
                        get_class($command)
                    ));
            }
        }

        return array_merge(
            $updateFileCommands,
            $addDirectoryCommands,
            $addFileCommands,
            $deleteFileCommands,
            $deleteDirectoryCommands
        );
    }
}
