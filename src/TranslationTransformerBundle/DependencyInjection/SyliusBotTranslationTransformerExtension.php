<?php

namespace SyliusBot\TranslationTransformerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SyliusBotTranslationTransformerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->extractConfigurationToParameters($container, $config, 'sylius_bot_transformer');

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }

    protected function extractConfigurationToParameters(ContainerBuilder $container, array $config, $base = '')
    {
        foreach ($config as $key => $value) {
            $path = $base . '.' . $key;

            if (is_array($value)) {
                $this->extractConfigurationToParameters($container, $value, $path);
            }

            $container->setParameter($path, $value);
        }
    }
}
