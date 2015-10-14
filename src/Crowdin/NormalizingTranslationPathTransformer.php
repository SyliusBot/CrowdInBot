<?php

namespace SyliusBot\Crowdin;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class NormalizingTranslationPathTransformer implements TranslationPathTransformerInterface
{
    /**
     * @var TranslationPathTransformerInterface
     */
    private $translationPathTransformer;

    /**
     * @var array
     */
    private $replacements;

    /**
     * @param TranslationPathTransformerInterface $translationPathTransformer
     * @param array $replacements
     */
    public function __construct(TranslationPathTransformerInterface $translationPathTransformer, array $replacements)
    {
        $this->translationPathTransformer = $translationPathTransformer;

        foreach ($replacements as $search => $replace) {
            $this->replacements['.' . $search . '.'] = '.' . $replace . '.';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function transformLocalPathToCrowdinPath($localPath)
    {
        return str_replace(
            array_values($this->replacements),
            array_keys($this->replacements),
            $this->translationPathTransformer->transformLocalPathToCrowdinPath($localPath)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function transformCrowdinPathToLocalPath($crowdinPath, $locale = null)
    {
        return str_replace(
            array_keys($this->replacements),
            array_values($this->replacements),
            $this->translationPathTransformer->transformCrowdinPathToLocalPath($crowdinPath, $locale)
        );
    }
}
