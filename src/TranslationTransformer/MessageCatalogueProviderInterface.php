<?php

namespace SyliusBot\TranslationTransformer;

use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface MessageCatalogueProviderInterface
{
    /**
     * @param string $locale
     *
     * @return MessageCatalogueInterface
     */
    public function getMessageCatalogue($locale = null);
}
