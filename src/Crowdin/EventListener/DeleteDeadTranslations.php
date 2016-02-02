<?php

namespace SyliusBot\Crowdin\EventListener;

use SyliusBot\Crowdin\Event\ArchiveExtractedEvent;
use SyliusBot\Crowdin\TranslationPathTransformerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class DeleteDeadTranslations
{
    /**
     * @var TranslationPathTransformerInterface
     */
    private $translationPathTransformer;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @param TranslationPathTransformerInterface $translationPathTransformer
     * @param string $defaultLocale
     */
    public function __construct(TranslationPathTransformerInterface $translationPathTransformer, $defaultLocale)
    {
        $this->translationPathTransformer = $translationPathTransformer;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @param ArchiveExtractedEvent $archiveExtractedEvent
     */
    public function apply(ArchiveExtractedEvent $archiveExtractedEvent)
    {
        /** @var Finder|SplFileInfo[] $finder */
        $finder = new Finder();
        $finder
            ->files()
            ->in($archiveExtractedEvent->getProjectPath())
            ->path('/.*?Bundle\/Resources\/translations.*?/')
            ->name('*.*.*')
        ;

        $files = array_map(
            function ($value) {
                return $this->translationPathTransformer->transformLocalPathToCrowdinPath($value);
            },
            $archiveExtractedEvent->getFiles()
        );
        foreach ($finder as $file) {
            if (
                false === strpos($file->getRelativePathname(), '.' . $this->defaultLocale . '.')
                && !in_array($this->translationPathTransformer->transformLocalPathToCrowdinPath($file->getRelativePathname()), $files, true)
            ) {
                unlink($file->getPathname());
            }
        }
    }
}
