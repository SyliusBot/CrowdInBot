<?php

namespace SyliusBot\CrowdinBundle\Command;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class UpSynchronizerCommand extends Command
{
    /**
     * @var SynchronizerInterface
     */
    private $upSynchronizer;

    /**
     * @param SynchronizerInterface $upSynchronizer
     */
    public function __construct(SynchronizerInterface $upSynchronizer)
    {
        parent::__construct();

        $this->upSynchronizer = $upSynchronizer;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sylius-bot:crowdin:synchronize:up')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->upSynchronizer->synchronize();
    }

}
