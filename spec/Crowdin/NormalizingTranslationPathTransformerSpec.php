<?php

namespace spec\SyliusBot\Crowdin;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Crowdin\TranslationPathTransformerInterface;

/**
 * @mixin \SyliusBot\Crowdin\TranslationPathTransformer
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class NormalizingTranslationPathTransformerSpec extends ObjectBehavior
{
    function let(TranslationPathTransformerInterface $translationPathTransformer)
    {
        $this->beConstructedWith($translationPathTransformer, ['pt_PT' => 'pt']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\NormalizingTranslationPathTransformer');
    }

    function it_implements_Translation_Path_Transformer_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\TranslationPathTransformerInterface');
    }

    function it_transforms_local_path_to_crowdin_path(TranslationPathTransformerInterface $translationPathTransformer)
    {
        $translationPathTransformer->transformLocalPathToCrowdinPath('local_pt.pt.yml')->willReturn('crowdin_pt.pt.yml');

        $this->transformLocalPathToCrowdinPath('local_pt.pt.yml')->shouldReturn('crowdin_pt.pt_PT.yml');
    }

    function it_transforms_crowdin_path_to_local_path(TranslationPathTransformerInterface $translationPathTransformer)
    {
        $translationPathTransformer->transformCrowdinPathToLocalPath('crowdin_pt_PT.pt_PT.yml', Argument::cetera())->willReturn('local_pt_PT.pt_PT.yml');

        $this->transformCrowdinPathToLocalPath('crowdin_pt_PT.pt_PT.yml')->shouldReturn('local_pt_PT.pt.yml');
    }
}
