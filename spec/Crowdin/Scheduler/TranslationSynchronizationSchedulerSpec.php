<?php

namespace spec\SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use Crowdin\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Crowdin\Model\TranslationInterface;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @mixin \SyliusBot\Crowdin\Scheduler\TranslationSynchronizationScheduler
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationSynchronizationSchedulerSpec extends ObjectBehavior
{
    function let(Client $crowdinClient)
    {
        $this->beConstructedWith($crowdinClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Scheduler\TranslationSynchronizationScheduler');
    }

    function it_implements_Synchronization_Scheduler_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\Scheduler\SynchronizationSchedulerInterface');
    }

    function it_schedules_translations_changes(
        Client $crowdinClient,
        TranslationProviderInterface $localTranslationProvider,
        TranslationProviderInterface $crowdinTranslationProvider,
        TranslationInterface $translationToAdd,
        TranslationInterface $translationToUpdate,
        TranslationInterface $translationToDelete,
        Api\AddFile $addFile,
        Api\UpdateFile $updateFile,
        Api\DeleteFile $deleteFile
    ) {
        $localTranslationProvider->getTranslations()->willReturn([
            $translationToAdd,
            $translationToUpdate
        ]);

        $crowdinTranslationProvider->getTranslations()->willReturn([
            $translationToUpdate,
            $translationToDelete
        ]);

        $translationToAdd->getLocalPath()->willReturn('src/FooBundle/translations/add.en.yml');
        $translationToAdd->getCrowdinPath()->willReturn('/Foo/add.en.yml');

        $crowdinClient->api('add-file')->willReturn($addFile);
        $addFile->addTranslation('src/FooBundle/translations/add.en.yml', '/Foo/add.en.yml')->shouldBeCalled();

        $translationToUpdate->getLocalPath()->willReturn('src/FooBundle/translations/update.en.yml');
        $translationToUpdate->getCrowdinPath()->willReturn('/Foo/update.en.yml');

        $crowdinClient->api('update-file')->willReturn($updateFile);
        $updateFile->addTranslation('src/FooBundle/translations/update.en.yml', '/Foo/update.en.yml')->shouldBeCalled();

        $translationToDelete->getCrowdinPath()->willReturn('/Foo/delete.en.yml');

        $crowdinClient->api('delete-file')->willReturn($deleteFile);
        $deleteFile->setFile('/Foo/delete.en.yml')->shouldBeCalled();

        $this->schedule($localTranslationProvider, $crowdinTranslationProvider)->shouldReturn([
            $addFile,
            $updateFile,
            $deleteFile
        ]);
    }
}
