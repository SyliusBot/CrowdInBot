<?php

namespace spec\SyliusBot\Crowdin\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\Crowdin\Model\TranslationInterface;
use SyliusBot\Crowdin\TranslationPathTransformerInterface;

/**
 * @mixin \SyliusBot\Crowdin\Factory\TranslationFactory
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationFactorySpec extends ObjectBehavior
{
    function let(TranslationPathTransformerInterface $translationPathTransformer)
    {
        $this->beConstructedWith($translationPathTransformer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\Factory\TranslationFactory');
    }

    function it_implements_Translation_Factory_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\Factory\TranslationFactoryInterface');
    }

    function it_creates_translation_from_crowdin_path(TranslationInterface $translation)
    {
        $translation->getCrowdinPath()->willReturn('CrowdinPath');
        $translation->getLocalPath()->willReturn(null);
        $translation->getExportPattern()->willReturn(null);

        $this->createFromCrowdinPath('CrowdinPath')->shouldBeSameAs($translation);
    }

    function it_creates_translation_from_local_path(TranslationPathTransformerInterface $translationPathTransformer, TranslationInterface $translation)
    {
        $translation->getCrowdinPath()->willReturn('CrowdinPath');
        $translation->getLocalPath()->willReturn('LocalPath');
        $translation->getExportPattern()->willReturn('ExportPattern');

        $translationPathTransformer->transformLocalPathToCrowdinPath('LocalPath')->willReturn('CrowdinPath');
        $translationPathTransformer->transformCrowdinPathToLocalPath('CrowdinPath')->willReturn('ExportPattern/translation.yml');

        $this->createFromLocalPath('LocalPath')->shouldBeSameAs($translation);
    }

    public function getMatchers()
    {
        return [
            'beSameAs' => function ($subject, $expected) {
                return null !== $subject
                    && $subject->getCrowdinPath() === $expected->getCrowdinPath()
                    && $subject->getLocalPath() === $expected->getLocalPath()
                    && $subject->getExportPattern() === $expected->getExportPattern()
                ;
            }
        ];
    }
}
