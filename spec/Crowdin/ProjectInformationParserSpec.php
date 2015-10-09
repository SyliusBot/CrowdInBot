<?php

namespace spec\SyliusBot\Crowdin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin \SyliusBot\Crowdin\ProjectInformationParser
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class ProjectInformationParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\ProjectInformationParser');
    }

    function it_implements_Project_Information_Parser_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\ProjectInformationParserInterface');
    }
}
