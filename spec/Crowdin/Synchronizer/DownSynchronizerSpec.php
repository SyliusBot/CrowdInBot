<?php

namespace spec\SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\ArchiveInterface;
use SyliusBot\Crowdin\CrowdinEvents;
use SyliusBot\Crowdin\Event\ArchiveExtractedEvent;
use SyliusBot\Crowdin\TranslationArchiveProviderInterface;
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
        EventDispatcherInterface $eventDispatcher,
        $projectPath = 'sources'
    ) {
        $this->beConstructedWith($gitSynchronizer, $translationArchiveProvider, $eventDispatcher, $projectPath);
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
        EventDispatcherInterface $eventDispatcher,
        $projectPath,
        ArchiveInterface $archive
    ) {
        $gitSynchronizer->synchronize()->shouldBeCalled();

        $translationArchiveProvider->getArchive()->willReturn($archive);
        $archive->extractDirectoryTo('src', $projectPath)->shouldBeCalled();

        $eventDispatcher->dispatch(CrowdinEvents::ARCHIVE_EXTRACTED, Argument::type(ArchiveExtractedEvent::class))->shouldBeCalled();

        $this->synchronize();
    }
}
