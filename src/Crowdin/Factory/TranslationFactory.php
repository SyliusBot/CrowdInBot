<?php

namespace SyliusBot\Crowdin\Factory;

use SyliusBot\Crowdin\Model\Translation;
use SyliusBot\Crowdin\TranslationPathTransformerInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class TranslationFactory implements TranslationFactoryInterface
{
    /**
     * @var TranslationPathTransformerInterface
     */
    private $translationPathTransformer;

    /**
     * @param TranslationPathTransformerInterface $translationPathTransformer
     */
    public function __construct(TranslationPathTransformerInterface $translationPathTransformer)
    {
        $this->translationPathTransformer = $translationPathTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromLocalPath($localPath)
    {
        $crowdinPath = $this->translationPathTransformer->transformLocalPathToCrowdinPath($localPath);

        $exportPattern = dirname($this->translationPathTransformer->transformCrowdinPathToLocalPath($crowdinPath));

        $translation = new Translation($crowdinPath, $localPath);
        $translation->setExportPattern($exportPattern);

        return $translation;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromCrowdinPath($crowdinPath)
    {
        return new Translation($crowdinPath);
    }
}
