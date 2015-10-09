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
}
