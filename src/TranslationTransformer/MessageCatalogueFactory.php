<?php

namespace SyliusBot\TranslationTransformer;

use Symfony\Component\Translation\MessageCatalogue;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class MessageCatalogueFactory implements MessageCatalogueFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($locale)
    {
        return new MessageCatalogue($locale);
    }
}
