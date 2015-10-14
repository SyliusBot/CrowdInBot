<?php

namespace SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use Crowdin\Client;
use SyliusBot\Crowdin\Model\TranslationInterface;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class TranslationSynchronizationScheduler implements SynchronizationSchedulerInterface
{
    /**
     * @var Client
     */
    private $crowdinClient;

    /**
     * @var string
     */
    private $exportPattern;

    /**
     * @var TranslationInterface[]
     */
    private $translationsToAdd = [];

    /**
     * @var TranslationInterface[]
     */
    private $translationsToUpdate = [];

    /**
     * @var TranslationInterface[]
     */
    private $translationsToDelete = [];

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
        $this->scheduleTranslationsChanges(
            $localTranslationProvider->getTranslations(),
            $crowdinTranslationProvider->getTranslations()
        );

        return $this->createApiCommandsBasedOnScheduledChanges();
    }

    /**
     * @return Api\ApiInterface[]
     */
    private function createApiCommandsBasedOnScheduledChanges()
    {
        $commands = [];

        foreach ($this->translationsToAdd as $translation) {
            /** @var Api\AddFile $addTranslation */
            $addTranslation = $this->crowdinClient->api('add-file');
            $addTranslation->addTranslation($translation->getLocalPath(), $translation->getCrowdinPath(), $translation->getExportPattern());

            $commands[] = $addTranslation;
        }

        foreach ($this->translationsToUpdate as $translation) {
            /** @var Api\UpdateFile $updateTranslation */
            $updateTranslation = $this->crowdinClient->api('update-file');
            $updateTranslation->addTranslation($translation->getLocalPath(), $translation->getCrowdinPath(), $translation->getExportPattern());

            $commands[] = $updateTranslation;
        }

        foreach ($this->translationsToDelete as $translation) {
            /** @var Api\DeleteFile $deleteTranslation */
            $deleteTranslation = $this->crowdinClient->api('delete-file');
            $deleteTranslation->setFile($translation->getCrowdinPath());

            $commands[] = $deleteTranslation;
        }

        return $commands;
    }

    /**
     * @param TranslationInterface[] $currentTranslations
     * @param TranslationInterface[] $crowdinTranslations
     */
    private function scheduleTranslationsChanges(array $currentTranslations, array $crowdinTranslations)
    {
        foreach ($currentTranslations as $currentTranslation) {
            $key = $this->getTranslationKeyInAnArray($currentTranslation, $crowdinTranslations);

            if (null === $key) {
                $this->translationsToAdd[] = $currentTranslation;
                continue;
            }

            $this->translationsToUpdate[] = $currentTranslation;
            unset($crowdinTranslations[$key]);
        }

        $this->translationsToDelete = $crowdinTranslations;
    }

    /**
     * @param TranslationInterface $searchedTranslation
     * @param TranslationInterface[] $translations
     *
     * @return string|null
     */
    private function getTranslationKeyInAnArray(TranslationInterface $searchedTranslation, array $translations)
    {
        foreach ($translations as $key => $translation) {
            if ($searchedTranslation->getCrowdinPath() === $translation->getCrowdinPath()) {
                return $key;
            }
        }

        return null;
    }
}
