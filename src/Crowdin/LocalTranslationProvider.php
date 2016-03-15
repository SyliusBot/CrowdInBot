<?php

namespace SyliusBot\Crowdin;

use SyliusBot\Crowdin\Factory\TranslationFactoryInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class LocalTranslationProvider implements TranslationProviderInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var TranslationFactoryInterface
     */
    private $translationFactory;

    /**
     * @param TranslationFactoryInterface $translationFactory
     * @param string $projectPath
     * @param string $searchPath
     * @param string $defaultLocale
     */
    public function __construct(TranslationFactoryInterface $translationFactory, $projectPath, $searchPath, $defaultLocale)
    {
        $this->translationFactory = $translationFactory;
        $this->path = rtrim($projectPath, '/') . '/' . rtrim($searchPath, '/') . '/';
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslations()
    {
        /** @var Finder|SplFileInfo[] $finder */
        $finder = new Finder();
        $finder
            ->files()
            ->in($this->path)
            ->path('/Sylius\/Bundle\/[^\/]+Bundle\/Resources\/translations.*?/')
            ->name(sprintf('*.%s.*', $this->defaultLocale))
        ;

        $translations = [];
        foreach ($finder as $file) {
            try {
                $translations[] = $this->translationFactory->createFromLocalPath($file->getPathname());
            } catch (\InvalidArgumentException $exception) {
                continue;
            }
        }

        return $translations;
    }

    /**
     * {@inheritdoc}
     */
    public function getDirectories()
    {
        $currentDirectories = [];
        foreach ($this->getTranslations() as $currentTranslation) {
            $currentDirectories[] = dirname($currentTranslation->getCrowdinPath());
        }

        return array_unique($currentDirectories);
    }
}
