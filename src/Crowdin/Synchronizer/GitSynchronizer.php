<?php

namespace SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use SyliusBot\Github\Model\BranchInterface;
use SyliusBot\GitWrapperInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class GitSynchronizer implements SynchronizerInterface
{
    /**
     * @var GitWrapperInterface
     */
    private $git;

    /**
     * @var BranchInterface
     */
    private $baseBranch;

    /**
     * @param GitWrapperInterface $git
     * @param BranchInterface $baseBranch
     */
    public function __construct(
        GitWrapperInterface $git,
        BranchInterface $baseBranch
    ) {
        $this->git = $git;
        $this->baseBranch = $baseBranch;
    }

    /**
     * {@inheritdoc}
     */
    public function synchronize()
    {
        $this->git->assertGitIsInitialized();
        $this->git->assertRemoteExists('origin');
        $this->git->assertRemoteExists('upstream');

        $this->update();
    }

    private function update()
    {
        $this->git->checkout($this->baseBranch->getName());
        $this->git->fetch('upstream');
        $this->git->merge('upstream/' . $this->baseBranch->getName());
        $this->git->push('origin ' . $this->baseBranch->getName());
    }
}
