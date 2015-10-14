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
        $files = $archiveExtractedEvent->getFiles();

        foreach ($files as $file) {
            if (!is_file($file)) {
                continue;
            }

            $this->doApply($file);
        }
    }

    /**
     * @param string $file
     */
    abstract protected function doApply($file);
}
