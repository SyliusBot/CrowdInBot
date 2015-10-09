<?php

namespace SyliusBot;

use SyliusBot\Github\Model\BranchInterface;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface GithubAdapterInterface
{
    /**
     * @param BranchInterface $baseBranch
     * @param BranchInterface $headBranch
     * @param string $title
     * @param string $description
     */
    public function openPullRequest(BranchInterface $baseBranch, BranchInterface $headBranch, $title, $description);
}
