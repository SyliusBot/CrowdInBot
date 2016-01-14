<?php

namespace SyliusBot\TranslationTransformer;

use SyliusBot\TranslationFinderInterface;
use Symfony\Component\Translation\Loader\LoaderInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class MessageCatalogueProvider implements MessageCatalogueProviderInterface
{
    /**
     * @var TranslationFinderInterface
     */
    private $translationFinder;

    /**
     * @var MessageCatalogueFactoryInterface
     */
    private $messageCatalogueFactory;

    /**
     * @var LoaderInterface
     */
    private $translationLoader;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @param TranslationFinderInterface $translationFinder
     * @param MessageCatalogueFactoryInterface $messageCatalogueFactory
     * @param LoaderInterface $translationLoader
     * @param string $defaultLocale
     */
    public function __construct(
        TranslationFinderInterface $translationFinder,
        MessageCatalogueFactoryInterface $messageCatalogueFactory,
        LoaderInterface $translationLoader,
        $defaultLocale
    ) {
        $this->translationFinder = $translationFinder;
        $this->messageCatalogueFactory = $messageCatalogueFactory;
        $this->translationLoader = $translationLoader;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageCatalogue($locale = null)
    {
        $locale = $locale ?: $this->defaultLocale;

        $messageCatalogue = $this->messageCatalogueFactory->create($locale);

        $translations = $this->translationFinder->findAll($locale);
        foreach ($translations as $translation) {
            $domain = explode('.', substr($translation, strrpos($translation, '/') + 1))[0];

            $messageCatalogue->addCatalogue(
                $this->translationLoader->load($translation, $locale, $domain)
            );
        }

        return $messageCatalogue;
    }
}
