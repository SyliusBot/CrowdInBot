<?php

namespace SyliusBot;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class GitWrapper implements GitWrapperInterface
{
    /**
     * @var CommandExecutorInterface
     */
    private $commandExecutor;

    /**
     * @var string
     */
    private $directory;

    /**
     * @param CommandExecutorInterface $commandExecutor
     * @param string $directory
     */
    public function __construct(CommandExecutorInterface $commandExecutor, $directory)
    {
        $this->commandExecutor = $commandExecutor;
        $this->directory = $directory;
    }

    /**
     * {@inheritdoc}
     */
    public function isInitialized()
    {
        return is_dir($this->directory . '/.git');
    }

    /**
     * {@inheritdoc}
     */
    public function hasRemote($remote)
    {
        return 0 !== (int) $this->commandExecutor->execute(sprintf(
            'cd %s && git remote -v | awk \'{ print $1 }\' | grep %s | wc -l',
            $this->directory,
            $remote
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function commit($message)
    {
        return $this->commandExecutor->execute(sprintf(
            'cd %s && git commit -m "%s"',
            $this->directory,
            addcslashes($message, '"')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function checkout($branch)
    {
        return $this->commandExecutor->execute(sprintf(
            'cd %s && git checkout %s',
            $this->directory,
            $branch
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function add($pathPattern)
    {
        return $this->commandExecutor->execute(sprintf(
            'cd %s && git add %s',
            $this->directory,
            $pathPattern
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function reset($pathPattern)
    {
        return $this->commandExecutor->execute(sprintf(
            'cd %s && git checkout HEAD -- %s',
            $this->directory,
            $pathPattern
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($command)
    {
        return $this->commandExecutor->execute(sprintf(
            'cd %s && git fetch %s',
            $this->directory,
            $command
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function merge($command)
    {
        return $this->commandExecutor->execute(sprintf(
            'cd %s && git merge %s',
            $this->directory,
            $command
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function push($command = '')
    {
        return $this->commandExecutor->execute(sprintf(
            'cd %s && git push %s',
            $this->directory,
            $command
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function stash($command)
    {
        return $this->commandExecutor->execute(sprintf(
            'cd %s && git stash %s',
            $this->directory,
            $command
        ));
    }

    public function assertGitIsInitialized()
    {
        if ($this->isInitialized()) {
            return;
        }

        throw new \RuntimeException(sprintf(
            'There is no repository initialized under "%s".',
            $this->directory
        ));
    }

    /**
     * @param string $remote
     */
    public function assertRemoteExists($remote)
    {
        if ($this->hasRemote($remote)) {
            return;
        }

        throw new \RuntimeException(sprintf(
            'There is no "%s" remote under "%s".',
            $remote,
            $this->directory
        ));
    }
}
