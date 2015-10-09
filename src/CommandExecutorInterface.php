<?php

namespace SyliusBot;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
interface CommandExecutorInterface
{
    /**
     * @param string $command
     *
     * @return string
     */
    public function execute($command);
}
