<?php

namespace spec\SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @mixin \SyliusBot\Crowdin\Scheduler\OrderingSynchronizationScheduler
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class OrderingSynchronizationSchedulerSpec extends ObjectBehavior
{
    function let(SynchronizationSchedulerInterface $decoratedSynchronizationScheduler)
    {
        $this->beConstructedWith($decoratedSynchronizationScheduler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Scheduler\OrderingSynchronizationScheduler');
    }

    function it_implements_Synchronization_Scheduler_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface');
    }

    function it_puts_commands_in_a_correct_order(
        SynchronizationSchedulerInterface $decoratedSynchronizationScheduler,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        Api\AddDirectory $addDirectory,
        Api\DeleteDirectory $deleteDirectory,
        Api\AddFile $addFile,
        Api\UpdateFile $updateFile,
        Api\DeleteFile $deleteFile
    ) {
        $decoratedSynchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider)->willReturn([
            $deleteDirectory,
            $addFile,
            $deleteFile,
            $updateFile,
            $addDirectory
        ]);

        $this->schedule($localTranslationProvider, $crowdinTranslationProvider)->shouldReturn([
            $updateFile,
            $addDirectory,
            $addFile,
            $deleteFile,
            $deleteDirectory
        ]);
    }
}
