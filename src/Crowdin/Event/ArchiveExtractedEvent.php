<?php

namespace SyliusBot\Crowdin\Event;

use SyliusBot\ArchiveInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class ArchiveExtractedEvent extends Event
{
    /**
     * @var string
     */
    private $projectPath;

    /**
     * @var string[]
     */
    private $files;

    /**
     * @param string $projectPath
     * @param string[] $files
     */
    public function __construct($projectPath, array $files = [])
    {
        $this->projectPath = $projectPath;
        $this->files = $files;
    }

    /**
     * @return string
     */
    public function getProjectPath()
    {
        return $this->projectPath;
    }

    /**
     * @return string[]
     */
    public function getFiles()
    {
        return $this->files;
    }
}
