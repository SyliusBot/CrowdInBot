<?php

namespace spec\SyliusBot\Crowdin\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin \SyliusBot\Crowdin\Model\Translation
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('CrowdinPath');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Model\Translation');
    }

    function it_implements_Translation_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\Model\TranslationInterface');
    }

    function it_can_have_only_crowdin_path()
    {
        $this->getCrowdinPath()->shouldReturn('CrowdinPath');
        $this->getLocalPath()->shouldReturn(null);
    }

    function it_can_have_local_path()
    {
        $this->beConstructedWith('CrowdinPath', 'LocalPath');

        $this->getCrowdinPath()->shouldReturn('CrowdinPath');
        $this->getLocalPath()->shouldReturn('LocalPath');
    }

    function it_has_export_pattern()
    {
        $this->getExportPattern()->shouldReturn(null);

        $this->setExportPattern('ExportPattern');
        $this->getExportPattern()->shouldReturn('ExportPattern');
    }
}
