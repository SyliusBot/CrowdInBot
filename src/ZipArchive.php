<?php

namespace SyliusBot;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class ZipArchive implements ArchiveInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var \ZipArchive
     */
    protected $zip;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;

        $this->zip = new \ZipArchive();
        if (true !== $this->zip->open($this->path)) {
            throw new \InvalidArgumentException(sprintf('Impossible to open the archive "%s".', $this->path));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getFiles()
    {
        $files = [];
        for ($i = 0; $i < $this->zip->numFiles; ++$i) {
            $files[] = $this->zip->getNameIndex($i);
        }

        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function extractTo($extractPath)
    {
        $this->zip->extractTo($extractPath);
    }

    /**
     * {@inheritdoc}
     */
    public function extractDirectoryTo($directory, $extractPath)
    {
        $filesToExtract = [];
        foreach ($this->getFiles() as $file) {
            if (0 === strpos($file, $directory)) {
                $filesToExtract[] = $file;
            }
        }

        $this->zip->extractTo($extractPath, $filesToExtract);
    }

    /**
     * {@inheritdoc}
     */
    public function copyFile($fromPath, $toPath)
    {
        return file_put_contents($toPath, @file_get_contents(sprintf('zip://%s#%s', $this->path, $fromPath)));
    }
}
