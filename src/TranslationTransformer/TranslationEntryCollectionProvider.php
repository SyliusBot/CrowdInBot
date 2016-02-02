<?php

namespace SyliusBot\TranslationTransformer;

use SyliusBot\TranslationTransformer\Factory\TranslationEntryCollectionFactoryInterface;
use SyliusBot\TranslationTransformer\Factory\TranslationEntryFactoryInterface;
use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryCollectionProvider implements TranslationEntryCollectionProviderInterface
{
    /**
     * @var TranslationEntryCollectionFactoryInterface
     */
    private $translationEntryCollectionFactory;

    /**
     * @var TranslationEntryFactoryInterface
     */
    private $translationEntryFactory;

    /**
     * @param TranslationEntryCollectionFactoryInterface $translationEntryCollectionFactory
     * @param TranslationEntryFactoryInterface $translationEntryFactory
     */
    public function __construct(
        TranslationEntryCollectionFactoryInterface $translationEntryCollectionFactory,
        TranslationEntryFactoryInterface $translationEntryFactory
    ) {
        $this->translationEntryCollectionFactory = $translationEntryCollectionFactory;
        $this->translationEntryFactory = $translationEntryFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(MessageCatalogueInterface $messageCatalogue)
    {
        $translationEntryCollections = [];
        foreach ($messageCatalogue->getDomains() as $domain) {
            $translationEntryCollections[$domain] = $this->getDomain($messageCatalogue, $domain);
        }

        return $translationEntryCollections;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomain(MessageCatalogueInterface $messageCatalogue, $domain = 'messages')
    {
        $translationEntries = [];
        foreach ($messageCatalogue->all($domain) as $key => $value) {
            $translationEntries[] = $this->translationEntryFactory->create($key, $value, $domain);
        }

        return $this->translationEntryCollectionFactory->create($domain, $translationEntries);
    }
}
