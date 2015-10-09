<?php

namespace SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use SyliusBot\Github\Model\BranchInterface;
use SyliusBot\GithubAdapterInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class GithubAwareDownSynchronizer implements SynchronizerInterface
{
    /**
     * @var SynchronizerInterface
     */
    private $downSynchronizer;

    /**
     * @var GithubAdapterInterface
     */
    private $githubAdapter;

    /**
     * @var BranchInterface
     */
    private $baseBranch;

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
     * @param GithubAdapterInterface $githubAdapter
     * @param BranchInterface $baseBranch
     * @param BranchInterface $headBranch
     * @param array $options
     */
    public function __construct(
        SynchronizerInterface $downSynchronizer,
        GithubAdapterInterface $githubAdapter,
        BranchInterface $baseBranch,
        BranchInterface $headBranch,
        array $options
    ) {
        $this->downSynchronizer = $downSynchronizer;
        $this->githubAdapter = $githubAdapter;
        $this->baseBranch = $baseBranch;
        $this->headBranch = $headBranch;
        $this->options = $options;

        $this->assertOptionExists('title');
        $this->assertOptionExists('description');
    }

    /**
     * {@inheritdoc}
     */
    public function synchronize()
    {
        $this->downSynchronizer->synchronize();

        $this->githubAdapter->openPullRequest(
            $this->baseBranch,
            $this->headBranch,
            $this->options['title'],
            $this->options['description']
        );
    }

    /**
     * @param string $option
     */
    private function assertOptionExists($option)
    {
        if (!isset($this->options[$option])) {
            throw new \InvalidArgumentException(sprintf(
                'Option "%s" is required!',
                $option
            ));
        }
    }
}
