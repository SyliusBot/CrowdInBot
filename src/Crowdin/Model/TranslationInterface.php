<?php

namespace SyliusBot\Crowdin\Model;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationInterface
{
    /**
     * @return string
     */
    public function getCrowdinPath();

    /**
     * @return string|null
     */
    public function getLocalPath();

    /**
     * @param string $exportPattern
     */
    public function setExportPattern($exportPattern);

    /**
     * @return string
     */
    public function getExportPattern();
}
