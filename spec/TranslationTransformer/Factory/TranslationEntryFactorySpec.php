<?php

namespace spec\SyliusBot\TranslationTransformer\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @mixin \SyliusBot\TranslationTransformer\Factory\TranslationEntryFactory
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\Factory\TranslationEntryFactory');
    }

    function it_implements_Translation_Entry_Factory_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\Factory\TranslationEntryFactoryInterface');
    }

    function it_creates_Translation_Entry(TranslationEntryInterface $translationEntry)
    {
        $translationEntry->getKey()->willReturn('key');
        $translationEntry->getValue()->willReturn('value');

        $this->create('key', 'value')->shouldBeSameAs($translationEntry);
    }

    public function getMatchers()
    {
        return [
            'beSameAs' => function ($subject, $expected) {
                return null !== $subject
                    && $subject->getKey() === $expected->getKey()
                    && $subject->getValue() === $expected->getValue()
                ;
            }
        ];
    }
}
