<?php

namespace spec\SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use Crowdin\Client;
use Crowdin\Translation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @mixin \SyliusBot\Crowdin\Scheduler\SparingSynchronizationScheduler
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class SparingSynchronizationSchedulerSpec extends ObjectBehavior
{
    function let(SynchronizationSchedulerInterface $decoratedSynchronizationScheduler)
    {
        $this->beConstructedWith($decoratedSynchronizationScheduler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Scheduler\SparingSynchronizationScheduler');
    }

    function it_implements_Synchronization_Scheduler_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface');
    }

    function it_merges_two_add_file_commands(
        SynchronizationSchedulerInterface $decoratedSynchronizationScheduler,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        Api\AddFile $addFirstFile,
        Api\AddFile $addSecondFile,
        Translation $translation
    ) {
        $decoratedSynchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider)->willReturn([
            $addFirstFile,
            $addSecondFile
        ]);

        $addSecondFile->getTranslations()->willReturn([$translation]);

        $translation->getLocalPath()->willReturn('translations/second.en.yml');
        $translation->getCrowdinPath()->willReturn('second.en.yml');

        $addFirstFile->addTranslation('translations/second.en.yml', 'second.en.yml')->shouldBeCalled();
        $addFirstFile->getTranslations()->willReturn([$translation]);

        $this->schedule($localTranslationProvider, $crowdinTranslationProvider)->shouldReturn([$addFirstFile]);
    }

    function it_merges_two_update_file_commands(
        SynchronizationSchedulerInterface $decoratedSynchronizationScheduler,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        Api\UpdateFile $updateFirstFile,
        Api\UpdateFile $updateSecondFile,
        Translation $translation
    ) {
        $decoratedSynchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider)->willReturn([
            $updateFirstFile,
            $updateSecondFile
        ]);

        $updateSecondFile->getTranslations()->willReturn([$translation]);

        $translation->getLocalPath()->willReturn('translations/second.en.yml');
        $translation->getCrowdinPath()->willReturn('second.en.yml');

        $updateFirstFile->addTranslation('translations/second.en.yml', 'second.en.yml')->shouldBeCalled();
        $updateFirstFile->getTranslations()->willReturn([$translation]);

        $this->schedule($localTranslationProvider, $crowdinTranslationProvider)->shouldReturn([$updateFirstFile]);
    }

    function it_merges_two_similar_commands_even_if_they_are_divided_by_the_other_one(
        SynchronizationSchedulerInterface $decoratedSynchronizationScheduler,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        Api\AddFile $addFirstFile,
        Api\AddFile $addSecondFile,
        Translation $addTranslation,
        Api\UpdateFile $updateFirstFile,
        Api\UpdateFile $updateSecondFile,
        Translation $updateTranslation
    ) {
        $decoratedSynchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider)->willReturn([
            $addFirstFile,
            $updateFirstFile,
            $addSecondFile,
            $updateSecondFile
        ]);

        $addSecondFile->getTranslations()->willReturn([$addTranslation]);

        $addTranslation->getLocalPath()->willReturn('translations/add-second.en.yml');
        $addTranslation->getCrowdinPath()->willReturn('add-second.en.yml');

        $addFirstFile->addTranslation('translations/add-second.en.yml', 'add-second.en.yml')->shouldBeCalled();
        $addFirstFile->getTranslations()->willReturn([$addTranslation]);

        $updateSecondFile->getTranslations()->willReturn([$updateTranslation]);

        $updateTranslation->getLocalPath()->willReturn('translations/update-second.en.yml');
        $updateTranslation->getCrowdinPath()->willReturn('update-second.en.yml');

        $updateFirstFile->addTranslation('translations/update-second.en.yml', 'update-second.en.yml')->shouldBeCalled();
        $updateFirstFile->getTranslations()->willReturn([$updateTranslation]);

        $this->schedule($localTranslationProvider, $crowdinTranslationProvider)->shouldReturn([$addFirstFile, $updateFirstFile]);
    }

    function it_merges_maximum_of_twenty_add_file_commands_to_one(
        SynchronizationSchedulerInterface $decoratedSynchronizationScheduler,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        Api\AddFile $addTwentyFiles, // The 1. file
        Api\AddFile $addFiveFiles, // The 21. file
        Api\AddFile $mergedAddFile,
        Translation $mergedTranslation
    ) {
        $scheduledCommands = [];
        for ($i = 0; $i < 25; ++$i) {
            $scheduledCommands[] = $mergedAddFile;
        }
        $scheduledCommands[0] = $addTwentyFiles;
        $scheduledCommands[20] = $addFiveFiles;

        $decoratedSynchronizationScheduler->schedule(
            $localTranslationProvider,
            $crowdinTranslationProvider
        )->willReturn($scheduledCommands);

        $mergedAddFile->getTranslations()->willReturn([$mergedTranslation]);
        $mergedTranslation->getLocalPath()->willReturn('translations/messages.en.yml');
        $mergedTranslation->getCrowdinPath()->willReturn('messages.en.yml');

        $addTwentyFiles->addTranslation('translations/messages.en.yml', 'messages.en.yml')->shouldBeCalledTimes(19);
        $addFiveFiles->addTranslation('translations/messages.en.yml', 'messages.en.yml')->shouldBeCalledTimes(4);

        $addTwentyFiles->getTranslations()->willReturn([$mergedTranslation]);
        $addFiveFiles->getTranslations()->willReturn([$mergedTranslation]);

        $this->schedule($localTranslationProvider, $crowdinTranslationProvider)->shouldReturn([
            $addTwentyFiles,
            $addFiveFiles
        ]);
    }

    function it_merges_maximum_of_twenty_update_file_commands_to_one(
        SynchronizationSchedulerInterface $decoratedSynchronizationScheduler,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        Api\UpdateFile $updateTwentyFiles, // The 1. file
        Api\UpdateFile $updateFiveFiles, // The 21. file
        Api\UpdateFile $mergedUpdateFile,
        Translation $mergedTranslation
    ) {
        $scheduledCommands = [];
        for ($i = 0; $i < 25; ++$i) {
            $scheduledCommands[] = $mergedUpdateFile;
        }
        $scheduledCommands[0] = $updateTwentyFiles;
        $scheduledCommands[20] = $updateFiveFiles;

        $decoratedSynchronizationScheduler->schedule(
            $localTranslationProvider,
            $crowdinTranslationProvider
        )->willReturn($scheduledCommands);

        $mergedUpdateFile->getTranslations()->willReturn([$mergedTranslation]);
        $mergedTranslation->getLocalPath()->willReturn('translations/messages.en.yml');
        $mergedTranslation->getCrowdinPath()->willReturn('messages.en.yml');

        $updateTwentyFiles->addTranslation('translations/messages.en.yml', 'messages.en.yml')->shouldBeCalledTimes(19);
        $updateFiveFiles->addTranslation('translations/messages.en.yml', 'messages.en.yml')->shouldBeCalledTimes(4);

        $updateTwentyFiles->getTranslations()->willReturn([$mergedTranslation]);
        $updateFiveFiles->getTranslations()->willReturn([$mergedTranslation]);

        $this->schedule($localTranslationProvider, $crowdinTranslationProvider)->shouldReturn([
            $updateTwentyFiles,
            $updateFiveFiles
        ]);
    }
}
