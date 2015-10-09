<?php

namespace SyliusBot;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface GitWrapperInterface
{
    /**
     * @return bool
     */
    public function isInitialized();

    /**
     * @param string $remote
     *
     * @return bool
     */
    public function hasRemote($remote);

    /**
     * @param string $message
     *
     * @return string
     */
    public function commit($message);

    /**
     * @param string $branch
     *
     * @return string
     */
    public function checkout($branch);

    /**
     * @param string $pathPattern
     *
     * @return string
     */
    public function add($pathPattern);

    /**
     * @param string $pathPattern
     *
     * @return string
     */
    public function reset($pathPattern);

    /**
     * @param string $command
     *
     * @return string
     */
    public function fetch($command);

    /**
     * @param string $command
     *
     * @return string
     */
    public function merge($command);

    /**
     * @param string $command
     *
     * @return string
     */
    public function push($command);

    /**
     * @param string $command
     *
     * @return string
     */
    public function stash($command);

    /**
     * @throws \InvalidArgumentException
     */
    public function assertGitIsInitialized();

    /**
     * @param string $remote
     *
     * @throws \InvalidArgumentException
     */
    public function assertRemoteExists($remote);
}
