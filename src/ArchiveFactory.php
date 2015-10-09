<?php

namespace SyliusBot;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class ArchiveFactory implements ArchiveFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createArchive($archivePath)
    {
        $this->assertArchiveExists($archivePath);

        if (false !== strpos($archivePath, '.zip')) {
            return new ZipArchive($archivePath);
        }

        throw new \InvalidArgumentException(sprintf('Could not find correct archive driver for "%s".', $archivePath));
    }

    /**
     * @param $archivePath
     */
    private function assertArchiveExists($archivePath)
    {
        if (!file_exists($archivePath)) {
            throw new \InvalidArgumentException(sprintf('Given file "%s" does not exist!', $archivePath));
        }
    }
}
