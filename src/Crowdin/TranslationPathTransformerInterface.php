<?php

namespace SyliusBot\Crowdin;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationPathTransformerInterface
{
    /**
     * @param string $localPath
     *
     * @return string
     *
     * @throws \InvalidArgumentException If transformation fails
     */
    public function transformLocalPathToCrowdinPath($localPath);

    /**
     * @param string $crowdinPath
     *
     * @return string
     *
     * @throws \InvalidArgumentException If transformation fails
     */
    public function transformCrowdinPathToLocalPath($crowdinPath);
}
