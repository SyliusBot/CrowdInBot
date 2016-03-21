<?php

namespace SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use SyliusBot\Crowdin\CrowdinEvents;
use SyliusBot\Crowdin\Event\ArchiveExtractedEvent;
use SyliusBot\Crowdin\TranslationArchiveProviderInterface;
use SyliusBot\Crowdin\TranslationPathTransformerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class DownSynchronizer implements SynchronizerInterface
{
    /**
     * @var SynchronizerInterface
     */
    private $gitSynchronizer;

    /**
     * @var TranslationArchiveProviderInterface
     */
    private $translationArchiveProvider;

    /**
     * @var TranslationPathTransformerInterface
     */
    private $translationPathTransformer;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var string
     */
    private $projectPath;

    /**
     * @param SynchronizerInterface $gitSynchronizer
     * @param TranslationArchiveProviderInterface $translationArchiveProvider
     * @param TranslationPathTransformerInterface $translationPathTransformer
     * @param EventDispatcherInterface $eventDispatcher
     * @param string $projectPath
     */
    public function __construct(
        SynchronizerInterface $gitSynchronizer,
        TranslationArchiveProviderInterface $translationArchiveProvider,
        TranslationPathTransformerInterface $translationPathTransformer,
        EventDispatcherInterface $eventDispatcher,
        $projectPath
    ) {
        $this->gitSynchronizer = $gitSynchronizer;
        $this->translationArchiveProvider = $translationArchiveProvider;
        $this->translationPathTransformer = $translationPathTransformer;
        $this->eventDispatcher = $eventDispatcher;
        $this->projectPath = $projectPath;
    }

    /**
     * {@inheritdoc}
     */
    public function synchronize()
    {
        $this->gitSynchronizer->synchronize();

        $files = [];
        $translationsArchive = $this->translationArchiveProvider->getArchive();
        foreach ($translationsArchive->getFiles() as $file) {
            try {
                $localPath = $this->projectPath . '/' . $this->translationPathTransformer->transformCrowdinPathToLocalPath($file);

                $this->translationPathTransformer->transformLocalPathToCrowdinPath($localPath);
            } catch (\InvalidArgumentException $exception) {
                continue;
            }

            $translationsArchive->copyFile($file, $localPath);

            file_put_contents($localPath, preg_replace('/^(\s+)/m', '\1\1', file_get_contents($localPath)));

            $files[] = $localPath;
        }

        $this->eventDispatcher->dispatch(
            CrowdinEvents::ARCHIVE_EXTRACTED,
            new ArchiveExtractedEvent($this->projectPath, $files)
        );
    }
}
