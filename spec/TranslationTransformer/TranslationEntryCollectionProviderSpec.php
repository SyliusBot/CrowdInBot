<?php

namespace spec\SyliusBot\TranslationTransformer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationTransformer\Factory\TranslationEntryCollectionFactoryInterface;
use SyliusBot\TranslationTransformer\Factory\TranslationEntryFactoryInterface;
use SyliusBot\TranslationTransformer\MessageCatalogueProviderInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;
use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * @mixin \SyliusBot\TranslationTransformer\TranslationEntryCollectionProvider
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryCollectionProviderSpec extends ObjectBehavior
{
    function let(
        TranslationEntryCollectionFactoryInterface $translationEntryCollectionFactory,
        TranslationEntryFactoryInterface $translationEntryFactory
    ) {
        $this->beConstructedWith($translationEntryCollectionFactory, $translationEntryFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\TranslationEntryCollectionProvider');
    }

    function it_implements_Translation_Entry_Collection_Provider_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\TranslationEntryCollectionProviderInterface');
    }

    function it_gets_translation_entry_collection_by_domain(
        TranslationEntryCollectionFactoryInterface $translationEntryCollectionFactory,
        TranslationEntryFactoryInterface $translationEntryFactory,
        MessageCatalogueInterface $messageCatalogue,
        TranslationEntryCollectionInterface $translationEntryCollection,
        TranslationEntryInterface $translationEntry
    ) {
        $messageCatalogue->all('flashes')->willReturn(['key' => 'value']);

        $translationEntryFactory->create('key', 'value')->willReturn($translationEntry);

        $translationEntryCollectionFactory->create('flashes', [$translationEntry])->willReturn($translationEntryCollection);

        $this->getDomain($messageCatalogue, 'flashes')->shouldReturn($translationEntryCollection);
    }

    function it_gets_all_translation_entry_collections_at_once(
        TranslationEntryCollectionFactoryInterface $translationEntryCollectionFactory,
        TranslationEntryFactoryInterface $translationEntryFactory,
        MessageCatalogueInterface $messageCatalogue,
        TranslationEntryCollectionInterface $translationEntryCollection,
        TranslationEntryInterface $translationEntry
    ) {
        $messageCatalogue->getDomains()->willReturn(['flashes']);
        $messageCatalogue->all('flashes')->willReturn(['key' => 'value']);

        $translationEntryFactory->create('key', 'value')->willReturn($translationEntry);

        $translationEntryCollectionFactory->create('flashes', [$translationEntry])->willReturn($translationEntryCollection);

        $this->getAll($messageCatalogue)->shouldReturn(['flashes' => $translationEntryCollection]);
    }
}
