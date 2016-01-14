<?php

namespace SyliusBot\TranslationTransformerBundle\Command;

use SyliusBot\TranslationTransformer\MessageCatalogueProviderInterface;
use SyliusBot\TranslationTransformer\TranslationEntryCollectionProviderInterface;
use SyliusBot\TranslationTransformer\TranslationManipulatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class DumpCommand extends Command
{
    /**
     * @var MessageCatalogueProviderInterface
     */
    private $messageCatalogueProvider;

    /**
     * @var TranslationEntryCollectionProviderInterface
     */
    private $translationEntryCollectionProvider;

    /**
     * @var TranslationManipulatorInterface
     */
    private $translationManipulator;

    /**
     * @param MessageCatalogueProviderInterface $messageCatalogueProvider
     * @param TranslationEntryCollectionProviderInterface $translationEntryCollectionProvider
     * @param TranslationManipulatorInterface $translationManipulator
     */
    public function __construct(
        MessageCatalogueProviderInterface $messageCatalogueProvider,
        TranslationEntryCollectionProviderInterface $translationEntryCollectionProvider,
        TranslationManipulatorInterface $translationManipulator
    ) {
        parent::__construct();

        $this->messageCatalogueProvider = $messageCatalogueProvider;
        $this->translationEntryCollectionProvider = $translationEntryCollectionProvider;
        $this->translationManipulator = $translationManipulator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sylius-bot:translation-transformer:dump')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $messageCatalogue = $this->messageCatalogueProvider->getMessageCatalogue();

        $translationEntriesCollections = $this->translationEntryCollectionProvider->getAll($messageCatalogue);

        foreach ($translationEntriesCollections as $domain => $translationEntryCollection) {
            $output->writeln("Domain: " . $domain);

            $translationEntriesChanges = $this->translationManipulator->getTranslationEntriesChanges($translationEntryCollection);
            foreach ($translationEntriesChanges as $translationEntryChange) {
                $output->writeln(sprintf(
                    'MODIFY (%s) [%s] "%s" TO [%s] "%s"',
                    $domain,
                    $translationEntryChange->getOldTranslationEntry()->getKey(),
                    $translationEntryChange->getOldTranslationEntry()->getValue(),
                    $translationEntryChange->getNewTranslationEntry()->getKey(),
                    $translationEntryChange->getNewTranslationEntry()->getValue()
                ));
            }
        }
    }

}
