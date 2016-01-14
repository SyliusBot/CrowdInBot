<?php

namespace SyliusBot\TranslationTransformerBundle;

use SyliusBot\TranslationTransformerBundle\DependencyInjection\Compiler\TranslationManipulatorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SyliusBotTranslationTransformerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TranslationManipulatorCompilerPass());
    }
}
