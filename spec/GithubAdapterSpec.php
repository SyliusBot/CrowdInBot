<?php

namespace spec\SyliusBot;

use Github\Api;
use Github\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Github\Model\BranchInterface;
use SyliusBot\Github\Model\RepositoryInterface;

/**
 * @mixin \SyliusBot\GithubAdapter
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class GithubAdapterSpec extends ObjectBehavior
{
    function let(Client $githubClient, $token = 'EXAMPLE_TOKEN')
    {
        $this->beConstructedWith($githubClient, $token);
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\GithubAdapter');
    }

    function it_implements_Github_Adapter_interface()
    {
        $this->shouldImplement('SyliusBot\GithubAdapterInterface');
    }

    function it_opens_pull_request(
        Client $githubClient,
        $token,
        Api\PullRequest $pullRequest,
        BranchInterface $baseBranch,
        RepositoryInterface $baseRepository,
        BranchInterface $headBranch,
        RepositoryInterface $headRepository
    ) {
        $githubClient->authenticate($token, null, Client::AUTH_HTTP_TOKEN)->shouldBeCalled();

        $githubClient->api('pull_request')->willReturn($pullRequest);

        $pullRequest->create(
            'BaseOrganization',
            'BaseRepository',
            [
                'base'  => 'BaseBranch',
                'head'  => 'HeadOrganization:HeadBranch',
                'title' => 'Title',
                'body'  => 'Description',
            ]
        )->shouldBeCalled();

        $baseBranch->getRepository()->willReturn($baseRepository);
        $baseBranch->getName()->willReturn('BaseBranch');
        
        $baseRepository->getOrganization()->willReturn('BaseOrganization');
        $baseRepository->getName()->willReturn('BaseRepository');

        $headBranch->getRepository()->willReturn($headRepository);
        $headBranch->getName()->willReturn('HeadBranch');

        $headRepository->getOrganization()->willReturn('HeadOrganization');
        $headRepository->getName()->willReturn('HeadRepository');

        $this->openPullRequest($baseBranch, $headBranch, 'Title', 'Description');
    }

    function it_authenticates_only_once_while_opening_more_than_one_pull_requests(
        Client $githubClient,
        $token,
        Api\PullRequest $pullRequest,
        BranchInterface $baseBranch,
        RepositoryInterface $baseRepository,
        BranchInterface $headBranch,
        RepositoryInterface $headRepository
    ) {
        $githubClient->authenticate($token, null, Client::AUTH_HTTP_TOKEN)->shouldBeCalledTimes(1);

        $githubClient->api('pull_request')->willReturn($pullRequest);

        $pullRequest->create(
            'BaseOrganization',
            'BaseRepository',
            [
                'base'  => 'BaseBranch',
                'head'  => 'HeadOrganization:HeadBranch',
                'title' => 'Title',
                'body'  => 'Description',
            ]
        )->shouldBeCalled();

        $baseBranch->getRepository()->willReturn($baseRepository);
        $baseBranch->getName()->willReturn('BaseBranch');

        $baseRepository->getOrganization()->willReturn('BaseOrganization');
        $baseRepository->getName()->willReturn('BaseRepository');

        $headBranch->getRepository()->willReturn($headRepository);
        $headBranch->getName()->willReturn('HeadBranch');

        $headRepository->getOrganization()->willReturn('HeadOrganization');
        $headRepository->getName()->willReturn('HeadRepository');

        // Let's open TWO pull requests!
        $this->openPullRequest($baseBranch, $headBranch, 'Title', 'Description');
        $this->openPullRequest($baseBranch, $headBranch, 'Title', 'Description');
    }
}
