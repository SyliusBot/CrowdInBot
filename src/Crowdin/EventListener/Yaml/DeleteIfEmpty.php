<?php

namespace SyliusBot\Crowdin\EventListener\Yaml;

use SyliusBot\Crowdin\EventListener\ArchiveExtractedEventListener;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class DeleteIfEmpty extends ArchiveExtractedEventListener
{
    /**
     * {@inheritdoc}
     */
    protected function doApply($file)
    {
        $toDelete = true;
        $lines = file($file);

        foreach ($lines as $line) {
            $line = trim($line);

            if (!empty($line) && 0 !== strpos($line, '#')) {
                $toDelete = false;
                break;
            }
        }

        if ($toDelete) {
            unlink($file);
        }
    }
}
