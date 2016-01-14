<?php

namespace spec\SyliusBot\TranslationTransformer\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\TranslationTransformer\Model\TranslationEntryCollectionInterface;
use SyliusBot\TranslationTransformer\Model\TranslationEntryInterface;

/**
 * @mixin \SyliusBot\TranslationTransformer\Factory\TranslationEntryCollectionFactory
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationEntryCollectionFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationTransformer\Factory\TranslationEntryCollectionFactory');
    }

    function it_implements_Translation_Entry_Collection_Factory_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationTransformer\Factory\TranslationEntryCollectionFactoryInterface');
    }

    function it_creates_Translation_Entry_Collection(
        TranslationEntryCollectionInterface $translationEntryCollection,
        TranslationEntryInterface $translationEntry
    ) {
        $translationEntry->getKey()->willReturn('key');

        $translationEntryCollection->getDomain()->willReturn('flashes');
        $translationEntryCollection->toArray()->willReturn(['key' => $translationEntry]);

        $this->create('flashes', [$translationEntry])->shouldBeSameAs($translationEntryCollection);
    }

    public function getMatchers()
    {
        return [
            'beSameAs' => function ($subject, $expected) {
                return null !== $subject
                    && $subject->getDomain() === $expected->getDomain()
                    && $subject->toArray() === $expected->toArray()
                ;
            }
        ];
    }
}
