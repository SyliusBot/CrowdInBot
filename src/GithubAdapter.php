<?php

namespace SyliusBot;

use Github\Api;
use Github\Client;
use SyliusBot\Github\Model\BranchInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class GithubAdapter implements GithubAdapterInterface
{
    /**
     * @var Client
     */
    private $githubClient;

    /**
     * @var string
     */
    private $token;

    /**
     * @var bool
     */
    private $authenticated = false;

    /**
     * @param Client $githubClient
     * @param string $token
     */
    public function __construct(Client $githubClient, $token)
    {
        $this->githubClient = $githubClient;
        $this->token = $token;
    }

    /**
     * {@inheritdoc}
     */
    public function openPullRequest(BranchInterface $baseBranch, BranchInterface $headBranch, $title, $description)
    {
        $this->authenticateIfNeeded();

        /** @var Api\PullRequest $pullRequest */
        $pullRequest = $this->githubClient->api('pull_request');
        $pullRequest->create(
            $baseBranch->getRepository()->getOrganization(),
            $baseBranch->getRepository()->getName(),
            [
                'base'  => $baseBranch->getName(),
                'head'  => sprintf('%s:%s', $headBranch->getRepository()->getOrganization(), $headBranch->getName()),
                'title' => $title,
                'body'  => $description,
            ]
        );
    }

    private function authenticateIfNeeded()
    {
        if (false === $this->authenticated) {
            $this->githubClient->authenticate($this->token, null, Client::AUTH_HTTP_TOKEN);

            $this->authenticated = true;
        }
    }

}
