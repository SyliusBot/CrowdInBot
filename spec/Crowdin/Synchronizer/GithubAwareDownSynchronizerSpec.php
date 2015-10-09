<?php

namespace spec\SyliusBot\Crowdin\Synchronizer;

use Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Github\Model\BranchInterface;
use SyliusBot\GithubAdapterInterface;
use SyliusBot\GitWrapperInterface;

/**
 * @mixin \SyliusBot\Crowdin\Synchronizer\GithubAwareDownSynchronizer
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class GithubAwareDownSynchronizerSpec extends ObjectBehavior
{
    function let(
        SynchronizerInterface $downSynchronizer,
        GithubAdapterInterface $githubAdapter,
        BranchInterface $baseBranch,
        BranchInterface $headBranch
    ) {
        $this->beConstructedWith(
            $downSynchronizer,
            $githubAdapter,
            $baseBranch,
            $headBranch,
            ['title' => 'title', 'description' => 'description']
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Synchronizer\GithubAwareDownSynchronizer');
    }

    function it_implements_Synchronizer_interface()
    {
        $this->shouldImplement('Jjanvier\Library\Crowdin\Synchronizer\SynchronizerInterface');
    }

    function it_opens_pull_request(
        SynchronizerInterface $downSynchronizer,
        GithubAdapterInterface $githubAdapter,
        BranchInterface $baseBranch,
        BranchInterface $headBranch
    ) {
        $downSynchronizer->synchronize()->shouldBeCalled();

        $githubAdapter->openPullRequest($baseBranch, $headBranch, 'title', 'description')->shouldBeCalled();

        $this->synchronize();
    }

    function it_throws_an_exception_if_option_title_does_not_exist(
        SynchronizerInterface $downSynchronizer,
        GithubAdapterInterface $githubAdapter,
        BranchInterface $baseBranch,
        BranchInterface $headBranch
    ) {
        $this->beConstructedWith($downSynchronizer, $githubAdapter, $baseBranch, $headBranch, ['description' => 'description']);

        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }

    function it_throws_an_exception_if_option_description_does_not_exist(
        SynchronizerInterface $downSynchronizer,
        GithubAdapterInterface $githubAdapter,
        BranchInterface $baseBranch,
        BranchInterface $headBranch
    ) {
        $this->beConstructedWith($downSynchronizer, $githubAdapter, $baseBranch, $headBranch, ['title' => 'title']);

        $this->shouldThrow('\InvalidArgumentException')->duringInstantiation();
    }
}
