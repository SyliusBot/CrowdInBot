<?php

namespace SyliusBot;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationFinderInterface
{
    /**
     * @param string $locale
     *
     * @return string[]
     */
    public function findAll($locale);
}
