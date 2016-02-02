<?php

namespace SyliusBot\TranslationTransformerBundle\Command;

use SyliusBot\TranslationTransformer\MessageCatalogueProviderInterface;
use SyliusBot\TranslationTransformer\TranslationEntryCollectionProviderInterface;
use SyliusBot\TranslationTransformer\TranslationManipulatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Yaml\Yaml;

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

        $translationEntriesCollection = $this->translationEntryCollectionProvider->getDomain($messageCatalogue, 'messages');

        $translationEntriesChanges = $this->translationManipulator->getTranslationEntriesChanges($translationEntriesCollection);
        foreach ($translationEntriesChanges as $translationEntryChange) {
            $output->writeln(sprintf(
                'RENAME %s TO %s',
                $translationEntryChange->getOldTranslationEntry()->getKey(),
                $translationEntryChange->getNewTranslationEntry()->getKey()
            ));
        }
    }

//    /**
//     * @param array $array
//     *
//     * @return array
//     */
//    private function deflattenArray(array $array) {
//        $output = [];
//        foreach ($array as $key => $value) {
//            $reference = &$output;
//
//            $dots = explode('.', $key);
//            foreach ($dots as $dot) {
//                if (!isset($reference[$dot])) {
//                    $reference[$dot] = [];
//                }
//
//                $reference = &$reference[$dot];
//            }
//
//            $reference = $value;
//        }
//
//        return $output;
//    }
}
