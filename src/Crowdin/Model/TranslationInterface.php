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
}
