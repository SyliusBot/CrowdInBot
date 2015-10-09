<?php

namespace SyliusBot\Crowdin;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class ProjectInformationParser implements ProjectInformationParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTranslationsPaths($data)
    {
        $xml = new \SimpleXMLElement($data);

        return $this->doGetTranslationsPaths($xml->files);
    }

    /**
     * @param \SimpleXMLElement $files
     * @param string $prefix
     *
     * @return string[]
     */
    private function doGetTranslationsPaths(\SimpleXMLElement $files, $prefix = '')
    {
        $translationsPaths = [];
        foreach ($files->item as $item) {
            $itemPath = $prefix . '/' . $item->name;

            if ('file' === (string) $item->node_type) {
                $translationsPaths[] = $itemPath;
                continue;
            }

            if (null !== $item->files) {
                $translationsPaths = array_merge(
                    $translationsPaths,
                    $this->doGetTranslationsPaths($item->files, $itemPath)
                );
            }
        }

        return $translationsPaths;
    }

    /**
     * {@inheritdoc}
     */
    public function getExistingDirectories($data)
    {
        $xml = new \SimpleXMLElement($data);

        return $this->doGetExistingDirectories($xml->files);
    }

    /**
     * @param \SimpleXMLElement $files
     * @param string $prefix
     *
     * @return string[]
     */
    private function doGetExistingDirectories(\SimpleXMLElement $files, $prefix = '')
    {
        $existingDirectories = [];
        foreach ($files->item as $item) {
            $itemPath = $prefix . '/' . $item->name;

            if ('file' === (string) $item->node_type) {
                continue;
            }

            $existingDirectories[] = $itemPath;

            if (null !== $item->files) {
                $existingDirectories = array_merge(
                    $existingDirectories,
                    $this->doGetExistingDirectories($item->files, $itemPath)
                );
            }
        }

        return $existingDirectories;
    }
}
