<?php


namespace SyliusBot\Crowdin\Model;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class Translation implements TranslationInterface
{
    /**
     * @var string
     */
    private $crowdinPath;

    /**
     * @var string|null
     */
    private $localPath;

    /**
     * @var string|null
     */
    private $exportPattern;

    /**
     * @param string $crowdinPath
     * @param string|null $localPath
     */
    public function __construct($crowdinPath, $localPath = null)
    {
        $this->crowdinPath = $crowdinPath;
        $this->localPath = $localPath;
    }

    /**
     * {@inheritdoc}
     */
    public function getCrowdinPath()
    {
        return $this->crowdinPath;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocalPath()
    {
        return $this->localPath;
    }

    /**
     * {@inheritdoc}
     */
    public function setExportPattern($exportPattern)
    {
        $this->exportPattern = $exportPattern;
    }

    /**
     * {@inheritdoc}
     */
    public function getExportPattern()
    {
        return $this->exportPattern;
    }
}
