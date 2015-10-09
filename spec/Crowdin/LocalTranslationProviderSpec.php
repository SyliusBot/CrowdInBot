<?php

namespace spec\SyliusBot\Crowdin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Crowdin\Factory\TranslationFactoryInterface;

/**
 * @mixin \SyliusBot\Crowdin\LocalTranslationProvider
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class LocalTranslationProviderSpec extends ObjectBehavior
{
    function let(TranslationFactoryInterface $translationFactory)
    {
        $this->beConstructedWith($translationFactory, 'ProjectPath', 'SearchPath', 'DefaultLocale');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\LocalTranslationProvider');
    }

    function it_implements_Translation_Provider_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\TranslationProviderInterface');
    }
}
