<?php

namespace SyliusBot;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface ArchiveInterface
{
    /**
     * @return string
     */
    public function getPath();

    /**
     * @return \SplFileInfo[]
     */
    public function getFiles();

    /**
     * @param string $extractPath
     */
    public function extractTo($extractPath);

    /**
     * @param string $directory
     * @param string $extractPath
     */
    public function extractDirectoryTo($directory, $extractPath);

    /**
     * @param string $fromPath
     * @param string $toPath
     */
    public function copyFile($fromPath, $toPath);
}
