<?php

namespace spec\SyliusBot\Crowdin\Synchronizer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\GitWrapperInterface;

/**
 * @mixin \SyliusBot\Crowdin\Synchronizer\GitSynchronizer
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class GitSynchronizerSpec extends ObjectBehavior
{
    function let(GitWrapperInterface $git, $projectPath)
    {
        $this->beConstructedWith($git, $projectPath);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Synchronizer\GitSynchronizer');
    }

    function it_implements_Synchronizer_interface()
    {
        $this->shouldImplement('Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface');
    }

    function it_throws_an_exception_if_git_is_not_initialized(GitWrapperInterface $git)
    {
        $git->assertGitIsInitialized()->willThrow(new \InvalidArgumentException());

        $git->checkout('master')->shouldNotBeCalled();

        $this->shouldThrow('\Exception')->during('synchronize');
    }

    function it_throws_an_exception_if_origin_remote_does_not_exist(GitWrapperInterface $git)
    {
        $git->assertGitIsInitialized()->shouldBeCalled();
        $git->assertRemoteExists('origin')->willThrow(new \InvalidArgumentException());

        $git->checkout('master')->shouldNotBeCalled();

        $this->shouldThrow('\Exception')->during('synchronize');
    }

    function it_throws_an_exception_if_upstream_remote_does_not_exist(GitWrapperInterface $git)
    {
        $git->assertGitIsInitialized()->shouldBeCalled();
        $git->assertRemoteExists('origin')->shouldBeCalled();
        $git->assertRemoteExists('upstream')->willThrow(new \InvalidArgumentException());

        $git->checkout('master')->shouldNotBeCalled();

        $this->shouldThrow('\Exception')->during('synchronize');
    }

    function it_updates_codebase_if_everything_went_all_right(GitWrapperInterface $git)
    {
        $git->assertGitIsInitialized()->shouldBeCalled();
        $git->assertRemoteExists('origin')->shouldBeCalled();
        $git->assertRemoteExists('upstream')->shouldBeCalled();

        $git->checkout('master')->shouldBeCalled();
        $git->fetch('upstream')->shouldBeCalled();
        $git->merge('upstream/master')->shouldBeCalled();
        $git->push('origin master')->shouldBeCalled();

        $this->synchronize();
    }
}
