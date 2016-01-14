<?php

namespace SyliusBot\TranslationTransformerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 */
class TranslationManipulatorCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('sylius_bot.translation_transformer.translation_manipulator')) {
            return;
        }

        $definition = $container->findDefinition('sylius_bot.translation_transformer.translation_manipulator');
        $taggedServices = $container->findTaggedServiceIds('sylius_bot.translation_transformer.translation_manipulator');

        $references = [];
        foreach ($taggedServices as $id => $tags) {
            $references[] = new Reference($id);
        }

        $definition->addArgument($references);
    }
}
