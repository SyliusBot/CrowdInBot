<?php

namespace SyliusBot\Crowdin;

use SyliusBot\ArchiveInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationArchiveProviderInterface
{
    /**
     * @return ArchiveInterface
     */
    public function getArchive();
}
