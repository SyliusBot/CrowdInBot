<?php

namespace SyliusBot\CrowdinBundle\Command;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class DownSynchronizerCommand extends Command
{
    /**
     * @var SynchronizerInterface
     */
    private $downSynchronizer;

    /**
     * @param SynchronizerInterface $downSynchronizer
     */
    public function __construct(SynchronizerInterface $downSynchronizer)
    {
        parent::__construct();

        $this->downSynchronizer = $downSynchronizer;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sylius-bot:crowdin:synchronize:down')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->downSynchronizer->synchronize();
    }

}
