<?php

namespace spec\SyliusBot\TranslationTransformer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * @mixin \SyliusBot\TranslationTransformer\MessageCatalogueFactory
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class MessageCatalogueFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\MessageCatalogueFactory');
    }

    function it_implements_Message_Catalogue_Factory_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\MessageCatalogueFactoryInterface');
    }

    function it_creates_Message_Catalogue(MessageCatalogueInterface $messageCatalogue)
    {
        $messageCatalogue->getLocale()->willReturn('pl');

        $this->create('pl')->shouldBeSameAs($messageCatalogue);
    }

    public function getMatchers()
    {
        return [
            'beSameAs' => function ($subject, $expected) {
                return null !== $subject
                    && $subject->getLocale() === $expected->getLocale()
                ;
            }
        ];
    }
}
