<?php

namespace spec\SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Github\Model\BranchInterface;
use SyliusBot\GitWrapperInterface;

/**
 * @mixin \SyliusBot\Crowdin\Synchronizer\GitAwareDownSynchronizer
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class GitAwareDownSynchronizerSpec extends ObjectBehavior
{
    function let(SynchronizerInterface $downSynchronizer, GitWrapperInterface $git, BranchInterface $headBranch)
    {
        $this->beConstructedWith($downSynchronizer, $git, $headBranch, ['message' => 'message']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Synchronizer\GitAwareDownSynchronizer');
    }

    function it_implements_Synchronizer_interface()
    {
        $this->shouldImplement('Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface');
    }

    function it_throws_an_exception_if_message_option_was_not_passed(SynchronizerInterface $downSynchronizer, GitWrapperInterface $git, BranchInterface $headBranch)
    {
        $this->beConstructedWith($downSynchronizer, $git, $headBranch, []);

        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    function it_throws_an_exception_if_git_is_not_initialized(SynchronizerInterface $downSynchronizer, GitWrapperInterface $git)
    {
        $downSynchronizer->synchronize()->shouldBeCalled();
        
        $git->assertGitIsInitialized()->willThrow(new \InvalidArgumentException());

        $this->shouldThrow('\Exception')->during('synchronize');
    }

    function it_throws_an_exception_if_remote_origin_does_not_exist(SynchronizerInterface $downSynchronizer, GitWrapperInterface $git)
    {
        $downSynchronizer->synchronize()->shouldBeCalled();
        
        $git->assertGitIsInitialized()->shouldBeCalled();
        $git->assertRemoteExists('origin')->willThrow(new \InvalidArgumentException());

        $this->shouldThrow('\Exception')->during('synchronize');
    }

    function it_commits_modified_translations(SynchronizerInterface $downSynchronizer, GitWrapperInterface $git, BranchInterface $headBranch)
    {
        $downSynchronizer->synchronize()->shouldBeCalled();
        
        $git->assertGitIsInitialized()->shouldBeCalled();
        $git->assertRemoteExists('origin')->shouldBeCalled();

        $headBranch->getName()->willReturn('new-branch');

        $git->checkout('-b new-branch')->shouldBeCalled();
        $git->add('. --all')->shouldBeCalled();
        $git->commit('message')->shouldBeCalled();
        $git->push('origin new-branch')->shouldBeCalled();
        
        $this->synchronize();
    }
}
