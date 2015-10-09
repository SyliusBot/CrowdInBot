<?php

namespace spec\SyliusBot;

use PhpSpec\ObjectBehavior;

/**
 * @mixin \SyliusBot\CommandExecutor
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class CommandExecutorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\CommandExecutor');
    }

    function it_implements_Command_Executor_interface()
    {
        $this->shouldImplement('SyliusBot\CommandExecutorInterface');
    }

    function it_executes_commands_and_returns_the_output()
    {
        $this->execute("echo abc")->shouldReturn("abc");
    }
}
