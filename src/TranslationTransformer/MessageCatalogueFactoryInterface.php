<?php

namespace SyliusBot\TranslationTransformer;

use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface MessageCatalogueFactoryInterface
{
    /**
     * @param string $locale
     *
     * @return MessageCatalogueInterface
     */
    public function create($locale);
}
