<?php

namespace spec\SyliusBot;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SyliusBot\FinderFactoryInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @mixin \SyliusBot\TranslationFinder
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationFinderSpec extends ObjectBehavior
{
    function let(FinderFactoryInterface $finderFactory)
    {
        $this->beConstructedWith($finderFactory, 'ProjectPath', 'SearchPath');
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\TranslationFinder');
    }

    function it_implements_Translation_Finder_interface()
    {
        $this->shouldImplement('SyliusBot\TranslationFinderInterface');
    }
    
    function it_searches_for_translations(FinderFactoryInterface $finderFactory, Finder $finder, \Iterator $iterator, SplFileInfo $file)
    {
        $finderFactory->create()->willReturn($finder);

        $finder->files()->shouldBeCalled()->willReturn($finder);
        $finder->in('ProjectPath/SearchPath')->shouldBeCalled()->willReturn($finder);
        $finder->path('Resources/translations')->shouldBeCalled()->willReturn($finder);
        $finder->name('*.pl.*')->shouldBeCalled()->willReturn($finder);

        $finder->getIterator()->willReturn($iterator);

        $file->getPathname()->willReturn('/foo/bar/messages.pl.yml');

        $iterator->rewind()->shouldBeCalled();
        $iterator->valid()->willReturn(true, false);
        $iterator->current()->willReturn($file);
        $iterator->next()->shouldBeCalled();

        $this->findAll('pl')->shouldReturn(['/foo/bar/messages.pl.yml']);
    }
}
