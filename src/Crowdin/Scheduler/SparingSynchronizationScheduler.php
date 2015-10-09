<?php


namespace SyliusBot\Crowdin\Scheduler;

use Crowdin\Api;
use SyliusBot\Crowdin\TranslationProviderInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class SparingSynchronizationScheduler implements SynchronizationSchedulerInterface
{
    /**
     * @var SynchronizationSchedulerInterface
     */
    private $synchronizationScheduler;

    /**
     * @var Api\ApiInterface[]
     */
    private $sparedCommands = [];

    /**
     * @var Api\ApiInterface[]|Api\AddFile[]|Api\UpdateFile[] Command FQCN as key
     */
    private $currentMainCommands = [];

    /**
     * @var int[] Command FQCN as key
     */
    private $currentMainCommandsCounter = [];

    /**
     * @param SynchronizationSchedulerInterface $synchronizationScheduler
     */
    public function __construct(SynchronizationSchedulerInterface $synchronizationScheduler)
    {
        $this->synchronizationScheduler = $synchronizationScheduler;
    }

    /**
     * {@inheritdoc}
     */
    public function schedule(TranslationProviderInterface $localTranslationProvider, TranslationProviderInterface $crowdinTranslationProvider)
    {
        $this->sparedCommands = $this->currentMainCommands = $this->currentMainCommandsCounter = [];

        $commands = $this->synchronizationScheduler->schedule($localTranslationProvider, $crowdinTranslationProvider);

        foreach ($commands as $command) {
            if (!$this->handleCommandAs($command, Api\AddFile::class) && !$this->handleCommandAs($command, Api\UpdateFile::class)) {
                $this->sparedCommands[] = $command;
            }
        }

        return $this->sparedCommands;
    }

    /**
     * @param Api\ApiInterface|Api\AddFile|Api\UpdateFile $command
     * @param string $commandClass FQCN
     *
     * @return bool
     */
    private function handleCommandAs(Api\ApiInterface $command, $commandClass)
    {
        if (!$command instanceof $commandClass) {
            return false;
        }

        if (empty($this->currentMainCommandsCounter[$commandClass])) {
            $this->currentMainCommandsCounter[$commandClass] = 0;
        }

        /** @var Api\AddFile|Api\UpdateFile $command */
        foreach ($command->getTranslations() as $translation) {
            if (empty($this->currentMainCommands[$commandClass])) {
                $this->currentMainCommands[$commandClass] = $command;
                $this->sparedCommands[] = $command;
                $this->currentMainCommandsCounter[$commandClass] = count($command->getTranslations());

                break;
            }

            $this->currentMainCommands[$commandClass]->addTranslation(
                $translation->getLocalPath(),
                $translation->getCrowdinPath()
            );

            ++$this->currentMainCommandsCounter[$commandClass];

            if (20 === $this->currentMainCommandsCounter[$commandClass]) {
                $this->currentMainCommands[$commandClass] = null;
                $this->currentMainCommandsCounter[$commandClass] = 0;
            }
        }

        return true;
    }
}
