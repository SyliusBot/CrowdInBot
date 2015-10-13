<?php


namespace SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use SyliusBot\Github\Model\BranchInterface;
use SyliusBot\GitWrapperInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class GitAwareDownSynchronizer implements SynchronizerInterface
{
    /**
     * @var SynchronizerInterface
     */
    private $downSynchronizer;

    /**
     * @var GitWrapperInterface
     */
    private $git;

    /**
     * @var BranchInterface
     */
    private $headBranch;

    /**
     * @var array
     */
    private $options;

    /**
     * @param SynchronizerInterface $downSynchronizer
     * @param GitWrapperInterface $git
     * @param BranchInterface $headBranch
     * @param array $options
     */
    public function __construct(
        SynchronizerInterface $downSynchronizer,
        GitWrapperInterface $git,
        BranchInterface $headBranch,
        array $options
    ) {
        $this->downSynchronizer = $downSynchronizer;
        $this->git = $git;
        $this->headBranch = $headBranch;
        $this->options = $options;

        $this->assertOptionExists('message');
    }

    /**
     * {@inheritdoc}
     */
    public function synchronize()
    {
        $this->downSynchronizer->synchronize();

        $this->git->assertGitIsInitialized();
        $this->git->assertRemoteExists('origin');

        $this->git->checkout('-b ' . $this->headBranch->getName());
        $this->git->add('. --all');
        $this->git->commit($this->options['message']);
        $this->git->push('origin ' . $this->headBranch->getName());
    }

    /**
     * @param string $option
     */
    private function assertOptionExists($option)
    {
        if (!isset($this->options[$option]{0})) {
            throw new \InvalidArgumentException(sprintf(
                'Option "%s" is required!',
                $option
            ));
        }
    }
}
