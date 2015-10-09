<?php
 
namespace SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use SyliusBot\Crowdin\CrowdinEvents;
use SyliusBot\Crowdin\Event\ArchiveExtractedEvent;
use SyliusBot\Crowdin\TranslationArchiveProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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
     * @param EventDispatcherInterface $eventDispatcher
     * @param string $projectPath
     */
    public function __construct(
        SynchronizerInterface $gitSynchronizer,
        TranslationArchiveProviderInterface $translationArchiveProvider,
        EventDispatcherInterface $eventDispatcher,
        $projectPath
    ) {
        $this->gitSynchronizer = $gitSynchronizer;
        $this->translationArchiveProvider = $translationArchiveProvider;
        $this->eventDispatcher = $eventDispatcher;
        $this->projectPath = $projectPath;
    }

    /**
     * {@inheritdoc}
     */
    public function synchronize()
    {
        $this->gitSynchronizer->synchronize();

        $translationsArchive = $this->translationArchiveProvider->getArchive();
        $translationsArchive->extractDirectoryTo('src', $this->projectPath);

        $this->eventDispatcher->dispatch(
            CrowdinEvents::ARCHIVE_EXTRACTED,
            new ArchiveExtractedEvent($translationsArchive, $this->projectPath)
        );
    }
}
