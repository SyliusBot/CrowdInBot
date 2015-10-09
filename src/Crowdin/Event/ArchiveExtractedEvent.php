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
     * @var ArchiveInterface
     */
    protected $archive;

    /**
     * @var string
     */
    private $projectPath;

    /**
     * @param ArchiveInterface $archive
     * @param string $projectPath
     */
    public function __construct(ArchiveInterface $archive, $projectPath)
    {
        $this->archive = $archive;
        $this->projectPath = $projectPath;
    }

    /**
     * @return ArchiveInterface
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * @return string
     */
    public function getProjectPath()
    {
        return $this->projectPath;
    }
}
