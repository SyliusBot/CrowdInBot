<?php

namespace spec\SyliusBot\Crowdin\Synchronizer;

use Crowdin\Api\ApiInterface;
use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use PhpSpec\ObjectBehavior;
use SyliusBot\Crowdin\TranslationProviderInterface;
use SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface;

/**
 * @mixin \SyliusBot\Crowdin\Synchronizer\UpSynchronizer
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class UpSynchronizerSpec extends ObjectBehavior
{
    function let(
        SynchronizerInterface $gitSynchronizer,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        SynchronizationSchedulerInterface $synchronizationScheduler
    ) {
        $this->beConstructedWith($gitSynchronizer, $localTranslationProvider, $crowdinTranslationProvider, $synchronizationScheduler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Synchronizer\UpSynchronizer');
    }

    function it_implements_Synchronizer_interface()
    {
        $this->shouldImplement('Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface');
    }

    function it_up_synchronizes_translations(
        SynchronizerInterface $gitSynchronizer,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        SynchronizationSchedulerInterface $synchronizationScheduler,
        ApiInterface $apiCommand
    ) {
        $gitSynchronizer->synchronize()->shouldBeCalled();

        $synchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider)->willReturn([$apiCommand]);

        $apiCommand->execute()->shouldBeCalled();

        $this->synchronize();
    }
}
