<?php

namespace SyliusBot;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface ArchiveFactoryInterface
{
    /**
     * @param string $archivePath
     *
     * @return ArchiveInterface
     */
    public function createArchive($archivePath);
}
