<?php

namespace SyliusBot\Crowdin\EventListener\Yaml;

use SyliusBot\Crowdin\EventListener\ArchiveExtractedEventListener;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class Clean extends ArchiveExtractedEventListener
{
    /**
     * {@inheritdoc}
     */
    protected function doApply($file)
    {
        $lines = file($file);

        foreach ($lines as $key => $line) {
            if (0 === strpos($line, '---')) {
                unset($lines[$key]);
            }
        }

        file_put_contents($file, implode("", $lines));
    }
}
