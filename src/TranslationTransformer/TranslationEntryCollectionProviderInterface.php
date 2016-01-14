<?php

namespace SyliusBot\TranslationTransformer;

use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface TranslationEntryCollectionProviderInterface
{
    /**
     * @param MessageCatalogueInterface $messageCatalogue
     *
     * @return Model\TranslationEntryCollectionInterface[]
     */
    public function getAll(MessageCatalogueInterface $messageCatalogue);

    /**
     * @param MessageCatalogueInterface $messageCatalogue
     * @param string $domain
     *
     * @return TranslationEntryCollectionInterface
     */
    public function getDomain(MessageCatalogueInterface $messageCatalogue, $domain = 'messages');
}
