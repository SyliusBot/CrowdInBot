<?php

namespace SyliusBot\CrowdinBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sylius_bot_crowdin');
        $rootNode
            ->children()
                ->arrayNode('crowdin')
                    ->children()
                        ->arrayNode('github')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('title')->defaultValue('[AUTO] Updated translations from Crowdin')->cannotBeEmpty()->end()
                                ->scalarNode('description')->defaultValue('')->isRequired()->end()
                            ->end()
                        ->end()
                        ->arrayNode('git')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('message')->defaultValue('Updated translations from Crowdin')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                        ->scalarNode('project_id')->cannotBeEmpty()->end()
                        ->scalarNode('api_key')->cannotBeEmpty()->end()
                        ->scalarNode('translation_header')->defaultValue('')->end()
                    ->end()
                ->end()
                ->arrayNode('github')
                    ->children()
                        ->scalarNode('authorization_token')->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('project')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('base')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('organization')->cannotBeEmpty()->end()
                                ->scalarNode('repository')->cannotBeEmpty()->end()
                                ->scalarNode('branch')->defaultValue('master')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                        ->arrayNode('head')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('organization')->cannotBeEmpty()->end()
                                ->scalarNode('repository')->cannotBeEmpty()->end()
                                ->scalarNode('branch')->defaultValue('master')->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                        ->arrayNode('locale_replacements')
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('path')->defaultValue('%kernel.root_dir%/../sources/')->cannotBeEmpty()->end()
                        ->scalarNode('search_path')->defaultValue('src/')->cannotBeEmpty()->end()
                        ->scalarNode('default_locale')->defaultValue('en')->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()
        ;

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
