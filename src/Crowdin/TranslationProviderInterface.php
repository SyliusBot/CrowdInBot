<?php

namespace SyliusBot\Crowdin;

use SyliusBot\Crowdin\Model\TranslationInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationProviderInterface
{
    /**
     * @return TranslationInterface[]
     */
    public function getTranslations();

    /**
     * @return string[]
     */
    public function getDirectories();
}
