<?php

namespace spec\SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @mixin \SyliusBot\Crowdin\Scheduler\CompositeSynchronizationScheduler
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class CompositeSynchronizationSchedulerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Scheduler\CompositeSynchronizationScheduler');
    }

    function it_implements_Synchronization_Scheduler_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface');
    }

    function it_combines_output_of_two_or_more_synchronization_schedulers(
        SynchronizationSchedulerInterface $directorySynchronizationScheduler,
        SynchronizationSchedulerInterface $translationSynchronizationScheduler,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        Api\ApiInterface $directoryCommand,
        Api\ApiInterface $translationCommand
    ) {
        $this->beConstructedWith([
            $directorySynchronizationScheduler,
            $translationSynchronizationScheduler
        ]);

        $directorySynchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider)->willReturn([
            $directoryCommand
        ]);

        $translationSynchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider)->willReturn([
            $translationCommand
        ]);

        $this->schedule($localTranslationProvider, $crowdinTranslationProvider)->shouldReturn([
            $directoryCommand,
            $translationCommand
        ]);
    }
}
