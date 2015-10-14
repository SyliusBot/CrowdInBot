<?php

namespace spec\SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\ArchiveInterface;
use SyliusBot\Crowdin\CrowdinEvents;
use SyliusBot\Crowdin\Event\ArchiveExtractedEvent;
use SyliusBot\Crowdin\TranslationArchiveProviderInterface;
use SyliusBot\Crowdin\TranslationPathTransformerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @mixin \SyliusBot\Crowdin\Synchronizer\DownSynchronizer
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class DownSynchronizerSpec extends ObjectBehavior
{
    function let(
        SynchronizerInterface $gitSynchronizer,
        TranslationArchiveProviderInterface $translationArchiveProvider,
        TranslationPathTransformerInterface $translationPathTransformer,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->beConstructedWith($gitSynchronizer, $translationArchiveProvider, $translationPathTransformer, $eventDispatcher, 'sources');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Synchronizer\DownSynchronizer');
    }

    function it_implements_Synchronizer_interface()
    {
        $this->shouldImplement('Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface');
    }

    function it_extracts_translation_archive_to_current_project(
        SynchronizerInterface $gitSynchronizer,
        TranslationArchiveProviderInterface $translationArchiveProvider,
        TranslationPathTransformerInterface $translationPathTransformer,
        EventDispatcherInterface $eventDispatcher,
        ArchiveInterface $archive
    ) {
        $gitSynchronizer->synchronize()->shouldBeCalled();

        $translationArchiveProvider->getArchive()->willReturn($archive);
        $archive->getFiles()->willReturn(['crowdin.en.yml']);

        $translationPathTransformer->transformCrowdinPathToLocalPath('crowdin.en.yml')->willReturn('local.en.yml');

        $archive->copyFile('crowdin.en.yml', 'sources/local.en.yml')->shouldBeCalled();

        $eventDispatcher->dispatch(CrowdinEvents::ARCHIVE_EXTRACTED, Argument::type(ArchiveExtractedEvent::class))->shouldBeCalled();

        $this->synchronize();
    }
}
