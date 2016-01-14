<?php


namespace SyliusBot;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationFinder implements TranslationFinderInterface
{
    /**
     * @var FinderFactoryInterface
     */
    private $finderFactoryInterface;

    /**
     * @var string
     */
    private $projectPath;

    /**
     * @var string
     */
    private $searchPath;

    /**
     * @param FinderFactoryInterface $finderFactoryInterface
     * @param string $projectPath
     * @param string $searchPath
     */
    public function __construct(FinderFactoryInterface $finderFactoryInterface, $projectPath, $searchPath)
    {
        $this->finderFactoryInterface = $finderFactoryInterface;
        $this->projectPath = $projectPath;
        $this->searchPath = $searchPath;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($locale)
    {
        $finder = $this->finderFactoryInterface->create();

        $finder
            ->files()
            ->name('*.' . $locale . '.*')
            ->in($this->projectPath . '/' . $this->searchPath)
            ->path('Resources/translations')
        ;

        $files = [];
        foreach ($finder as $file) {
            $files[] = $file->getPathname();
        }

        return $files;
    }
}
