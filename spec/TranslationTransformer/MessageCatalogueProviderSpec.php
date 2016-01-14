<?php

namespace spec\SyliusBot\TranslationTransformer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationFinderInterface;
use SyliusBot\TranslationTransformer\MessageCatalogueFactoryInterface;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * @mixin \SyliusBot\TranslationTransformer\MessageCatalogueProvider
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class MessageCatalogueProviderSpec extends ObjectBehavior
{
    function let(
        TranslationFinderInterface $translationFinder,
        MessageCatalogueFactoryInterface $messageCatalogueFactory,
        LoaderInterface $loader
    ) {
        $this->beConstructedWith($translationFinder, $messageCatalogueFactory, $loader, 'en');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\MessageCatalogueProvider');
    }

    function it_implements_Message_Catalogue_Provider_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\MessageCatalogueProviderInterface');
    }

    function it_creates_message_catalogue_for_given_locale(
        TranslationFinderInterface $translationFinder,
        MessageCatalogueFactoryInterface $messageCatalogueFactory,
        LoaderInterface $loader,
        MessageCatalogueInterface $messageCatalogue,
        MessageCatalogueInterface $fooMessageCatalogue
    ) {
        $translationFinder->findAll('pl')->willReturn(['/foo/domain.pl.yml']);

        $loader->load('/foo/domain.pl.yml', 'pl', 'domain')->willReturn($fooMessageCatalogue);

        $messageCatalogueFactory->create('pl')->willReturn($messageCatalogue);

        $messageCatalogue->addCatalogue($fooMessageCatalogue)->shouldBeCalled();

        $this->getMessageCatalogue('pl')->shouldReturn($messageCatalogue);
    }

    function it_creates_message_catalogue_for_default_locale_if_there_is_no_locale_given(
        TranslationFinderInterface $translationFinder,
        MessageCatalogueFactoryInterface $messageCatalogueFactory,
        LoaderInterface $loader,
        MessageCatalogueInterface $messageCatalogue,
        MessageCatalogueInterface $fooMessageCatalogue
    ) {
        $translationFinder->findAll('en')->willReturn(['/foo/domain.en.yml']);

        $loader->load('/foo/domain.en.yml', 'en', 'domain')->willReturn($fooMessageCatalogue);

        $messageCatalogueFactory->create('en')->willReturn($messageCatalogue);

        $messageCatalogue->addCatalogue($fooMessageCatalogue)->shouldBeCalled();

        $this->getMessageCatalogue()->shouldReturn($messageCatalogue);
    }
}
