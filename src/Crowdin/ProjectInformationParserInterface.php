<?php

namespace SyliusBot\Crowdin;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface ProjectInformationParserInterface
{
    /**
     * @param string $data Output of Crowdin "Info" API endpoint
     *
     * @return string[]
     */
    public function getTranslationsPaths($data);

    /**
     * @param string $data Output of Crowdin "Info" API endpoint
     *
     * @return string[]
     */
    public function getExistingDirectories($data);
}
