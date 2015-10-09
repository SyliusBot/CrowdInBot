<?php

namespace spec\SyliusBot\Crowdin;

use Crowdin\Api;
use Crowdin\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\ArchiveFactoryInterface;
use SyliusBot\ArchiveInterface;

/**
 * @mixin \SyliusBot\Crowdin\TranslationArchiveProvider
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationArchiveProviderSpec extends ObjectBehavior
{
    function let(Client $crowdinClient, ArchiveFactoryInterface $archiveFactory)
    {
        $this->beConstructedWith($crowdinClient, $archiveFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\TranslationArchiveProvider');
    }

    function it_implements_Translation_Archive_Provider_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\TranslationArchiveProviderInterface');
    }

    function it_provides_translation_archive(
        Client $crowdinClient,
        ArchiveFactoryInterface $archiveFactory,
        ArchiveInterface $archive,
        Api\Export $exportCommand,
        Api\Download $downloadCommand
    ) {
        $crowdinClient->api('export')->willReturn($exportCommand);
        $exportCommand->execute()->shouldBeCalled();

        $crowdinClient->api('download')->willReturn($downloadCommand);
        $downloadCommand->setCopyDestination('/tmp')->shouldBeCalled();
        $downloadCommand->setPackage('all.zip')->shouldBeCalled();
        $downloadCommand->execute()->shouldBeCalled();

        $archiveFactory->createArchive('/tmp/all.zip')->willReturn($archive);

        $this->getArchive()->shouldReturn($archive);
    }
}
