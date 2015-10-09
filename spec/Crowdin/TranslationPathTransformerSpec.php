<?php

namespace spec\SyliusBot\Crowdin;

use PhpSpec\ObjectBehavior;

/**
 * @mixin \SyliusBot\Crowdin\TranslationPathTransformer
 *
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationPathTransformerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('en');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('SyliusBot\Crowdin\TranslationPathTransformer');
    }

    function it_implements_Translation_Path_Transformer_interface()
    {
        $this->shouldImplement('SyliusBot\Crowdin\TranslationPathTransformerInterface');
    }

    function it_transforms_local_path_to_crowdin_path()
    {
        $localPath = 'src/Sylius/Bundles/ExampleBundle/Resources/translations/messages.en_US.yml';

        $this->transformLocalPathToCrowdinPath($localPath)->shouldReturn('/ExampleBundle/messages.en_US.yml');
    }

    function it_throws_exception_if_local_path_transformation_fails()
    {
        $this
            ->shouldThrow('\InvalidArgumentException')
            ->during('transformLocalPathToCrowdinPath', ['InvalidPath/Bundle/messages.en.yml'])
        ;
    }

    function it_transforms_crowdin_path_without_locale_to_local_path()
    {
        $crowdinPath = 'ExampleBundle/messages.en.yml';
        $localPath = 'src/Sylius/Bundle/ExampleBundle/Resources/translations/messages.en.yml';

        $this->transformCrowdinPathToLocalPath($crowdinPath)->shouldReturn($localPath);

        $crowdinPath = '/ExampleBundle/messages.en.yml';
        $localPath = 'src/Sylius/Bundle/ExampleBundle/Resources/translations/messages.en.yml';

        $this->transformCrowdinPathToLocalPath($crowdinPath)->shouldReturn($localPath);
    }

    function it_transforms_crowdin_path_with_locale_to_local_path()
    {
        $crowdinPath = 'pl/ExampleBundle/messages.en.yml';
        $localPath = 'src/Sylius/Bundle/ExampleBundle/Resources/translations/messages.pl.yml';

        $this->transformCrowdinPathToLocalPath($crowdinPath)->shouldReturn($localPath);

        $crowdinPath = '/pl/ExampleBundle/messages.en.yml';
        $localPath = 'src/Sylius/Bundle/ExampleBundle/Resources/translations/messages.pl.yml';

        $this->transformCrowdinPathToLocalPath($crowdinPath)->shouldReturn($localPath);
    }

    function it_transforms_crowdin_path_with_full_locale_to_local_path()
    {
        $crowdinPath = 'en-US/ExampleBundle/messages.en.yml';
        $localPath = 'src/Sylius/Bundle/ExampleBundle/Resources/translations/messages.en_US.yml';

        $this->transformCrowdinPathToLocalPath($crowdinPath)->shouldReturn($localPath);

        $crowdinPath = '/en-US/ExampleBundle/messages.en.yml';
        $localPath = 'src/Sylius/Bundle/ExampleBundle/Resources/translations/messages.en_US.yml';

        $this->transformCrowdinPathToLocalPath($crowdinPath)->shouldReturn($localPath);
    }
}
