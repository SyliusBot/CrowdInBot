<?php
 
namespace SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
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
     * @param GitWrapperInterface $gitWrapperInterface
     */
    public function __construct(GitWrapperInterface $gitWrapperInterface)
    {
        $this->git = $gitWrapperInterface;
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
        $this->git->checkout('master');
        $this->git->fetch('upstream');
        $this->git->merge('upstream/master');
        $this->git->push('origin master');
    }
}
