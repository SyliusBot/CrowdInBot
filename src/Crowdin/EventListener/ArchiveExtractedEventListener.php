<?php

namespace SyliusBot\Crowdin\EventListener;

use SyliusBot\Crowdin\Event\ArchiveExtractedEvent;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
abstract class ArchiveExtractedEventListener
{
    /**
     * @param ArchiveExtractedEvent $archiveExtractedEvent
     */
    public function apply(ArchiveExtractedEvent $archiveExtractedEvent)
    {
        $files = $archiveExtractedEvent->getArchive()->getFiles();

        foreach ($files as $file) {
            $realpath = $archiveExtractedEvent->getProjectPath() . '/' . $file;

            if (!is_file($realpath)) {
                continue;
            }

            $this->doApply($realpath);
        }
    }

    /**
     * @param string $file
     */
    abstract protected function doApply($file);
}
