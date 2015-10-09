<?php

namespace spec\SyliusBot\Crowdin;

use Crowdin\Api;
use Crowdin\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Crowdin\Factory\TranslationFactoryInterface;
use SyliusBot\Crowdin\Model\TranslationInterface;
use SyliusBot\Crowdin\ProjectInformationParserInterface;

/**
 * @mixin \SyliusBot\Crowdin\CrowdinTranslationProvider
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class CrowdinTranslationProviderSpec extends ObjectBehavior
{
    function let(
        TranslationFactoryInterface $translationFactory,
        ProjectInformationParserInterface $projectInformationParser,
        Client $crowdinClient
    ) {
        $this->beConstructedWith($translationFactory, $projectInformationParser, $crowdinClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\CrowdinTranslationProvider');
    }

    function it_implements_Translation_Provider_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\TranslationProviderInterface');
    }

    function it_provides_crowdin_translations(
        TranslationFactoryInterface $translationFactory,
        ProjectInformationParserInterface $projectInformationParser,
        Client $crowdinClient,
        Api\Info $info,
        TranslationInterface $translation
    ) {
        $crowdinClient->api('info')->willReturn($info);
        $info->execute()->willReturn('DATA');

        $projectInformationParser->getTranslationsPaths('DATA')->willReturn(['/Crowdin/messages.en.yml']);

        $translationFactory->createFromCrowdinPath('/Crowdin/messages.en.yml')->willReturn($translation);

        $this->getTranslations()->shouldReturn([$translation]);
    }

    function it_provides_crowdin_directories(
        ProjectInformationParserInterface $projectInformationParser,
        Client $crowdinClient,
        Api\Info $info
    ) {
        $crowdinClient->api('info')->willReturn($info);
        $info->execute()->willReturn('DATA');

        $projectInformationParser->getExistingDirectories('DATA')->willReturn(['/Crowdin']);

        $this->getDirectories()->shouldReturn(['/Crowdin']);
    }

}
