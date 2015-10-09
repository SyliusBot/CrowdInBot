<?php

namespace SyliusBot\Crowdin\Factory;

use SyliusBot\Crowdin\Model\TranslationInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationFactoryInterface
{
    /**
     * @param string $localPath
     *
     * @return TranslationInterface
     */
    public function createFromLocalPath($localPath);

    /**
     * @param string $crowdinPath
     *
     * @return TranslationInterface
     */
    public function createFromCrowdinPath($crowdinPath);
}
