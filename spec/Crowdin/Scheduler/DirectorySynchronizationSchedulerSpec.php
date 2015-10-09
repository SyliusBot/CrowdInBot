<?php

namespace spec\SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use Crowdin\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @mixin \SyliusBot\Crowdin\Scheduler\DirectorySynchronizationScheduler
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class DirectorySynchronizationSchedulerSpec extends ObjectBehavior
{
    function let(Client $crowdinClient)
    {
        $this->beConstructedWith($crowdinClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Scheduler\DirectorySynchronizationScheduler');
    }

    function it_implements_Synchronization_Scheduler_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface');
    }

    function it_schedules_directory_changes(
        Client $crowdinClient,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        Api\AddDirectory $addDirectory,
        Api\DeleteDirectory $deleteDirectory
    ) {
        $localTranslationProvider->getDirectories()->willReturn(['/Foo', '/Bar']);
        $crowdinTranslationProvider->getDirectories()->willReturn(['/Bar', '/Baz']);

        $crowdinClient->api('add-directory')->willReturn($addDirectory);
        $addDirectory->setDirectory('/Foo')->shouldBeCalled();

        $crowdinClient->api('delete-directory')->willReturn($deleteDirectory);
        $deleteDirectory->setDirectory('/Baz')->shouldBeCalled();

        $this->schedule($localTranslationProvider, $crowdinTranslationProvider)->shouldReturn([$addDirectory, $deleteDirectory]);
    }
}
