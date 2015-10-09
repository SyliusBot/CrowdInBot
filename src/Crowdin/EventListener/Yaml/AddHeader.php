<?php

namespace SyliusBot\Crowdin\EventListener\Yaml;

use SyliusBot\Crowdin\EventListener\ArchiveExtractedEventListener;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class AddHeader extends ArchiveExtractedEventListener
{
    /**
     * @var string
     */
    private $header;

    /**
     * @param string $header
     */
    public function __construct($header)
    {
        $this->header = $header;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply($file)
    {
        $contents = file_get_contents($file);

        file_put_contents($file, $this->header . $contents);
    }
}
