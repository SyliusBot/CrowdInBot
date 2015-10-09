<?php

namespace SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use Crowdin\Client;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class DirectorySynchronizationScheduler implements SynchronizationSchedulerInterface
{
    /**
     * @var Client
     */
    private $crowdinClient;

    /**
     * @var string[]
     */
    private $directoriesToAdd = [];

    /**
     * @var string[]
     */
    private $directoriesToDelete = [];

    /**
     * @param Client $crowdinClient
     */
    public function __construct(Client $crowdinClient)
    {
        $this->crowdinClient = $crowdinClient;
    }

    /**
     * {@inheritdoc}
     */
    public function schedule(TranslationProviderInterface $localTranslationProvider, TranslationProviderInterface $crowdinTranslationProvider)
    {
        $this->directoriesToAdd = [];
        $this->directoriesToDelete = [];

        $this->scheduleDirectoriesChanges(
            $localTranslationProvider->getDirectories(),
            $crowdinTranslationProvider->getDirectories()
        );

        return $this->createApiCommandsBasedOnScheduledChanges();
    }

    /**
     * @param array $currentDirectories
     * @param array $crowdinDirectories
     */
    private function scheduleDirectoriesChanges(array $currentDirectories, array $crowdinDirectories)
    {
        foreach ($currentDirectories as $currentDirectory) {
            if (!in_array($currentDirectory, $crowdinDirectories)) {
                $this->directoriesToAdd[] = $currentDirectory;
                continue;
            }

            unset($crowdinDirectories[array_search($currentDirectory, $crowdinDirectories)]);
        }

        $this->directoriesToDelete = $crowdinDirectories;
    }

    /**
     * @return Api\ApiInterface[]
     */
    private function createApiCommandsBasedOnScheduledChanges()
    {
        $commands = [];

        foreach ($this->directoriesToAdd as $directory) {
            /** @var Api\AddDirectory $addDirectory */
            $addDirectory = $this->crowdinClient->api('add-directory');
            $addDirectory->setDirectory($directory);

            $commands[] = $addDirectory;
        }

        foreach ($this->directoriesToDelete as $directory) {
            /** @var Api\DeleteDirectory $deleteDirectory */
            $deleteDirectory = $this->crowdinClient->api('delete-directory');
            $deleteDirectory->setDirectory($directory);

            $commands[] = $deleteDirectory;
        }

        return $commands;
    }
}
