<?php
 
namespace SyliusBot;
 
/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
final class CommandExecutor implements CommandExecutorInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute($command)
    {
        return trim(`$command`);
    }
}
