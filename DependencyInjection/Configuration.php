<?php

namespace Black\Bundle\ArticleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Black\Bundle\ArticleBundle\DependencyInjection
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('black_article');

        $supportedDrivers = array('mongodb', 'orm');

        $rootNode
            ->children()

            ->scalarNode('db_driver')
                ->isRequired()
                ->validate()
                    ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver must be either \'mongodb\', \'orm\'.')
                    ->end()
                ->end()

                ->scalarNode('article_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('item_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('category_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('article_manager')->defaultValue('Black\\Bundle\\ArticleBundle\\Doctrine\\ArticleManager')->end()
                ->scalarNode('category_manager')->defaultValue('Black\\Bundle\\ArticleBundle\\Doctrine\\CategoryManager')->end()

            ->end();

        $this->addArticleSection($rootNode);
        $this->addProxySection($rootNode);
        $this->addCategorySection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addArticleSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('article')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                        ->children()
                        ->arrayNode('form')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')
                                    ->defaultValue('black_article_article_form')
                                ->end()
                                ->scalarNode('type')
                                    ->defaultValue('Black\\Bundle\\ArticleBundle\\Form\\Type\\ArticleType')
                                ->end()
                                ->scalarNode('item_type')
                                    ->defaultValue('Black\\Bundle\\ArticleBundle\\Form\\Type\\ItemType')
                                ->end()
                                ->scalarNode('handler')
                                    ->defaultValue('Black\\Bundle\\ArticleBundle\\Form\\Handler\\ArticleFormHandler')
                                ->end()
                                ->scalarNode('enabled_list')
                                    ->defaultValue('Black\\Bundle\\ArticleBundle\\Form\\ChoiceList\\EnabledList')
                                ->end()
                                ->scalarNode('status_list')
                                    ->defaultValue('Black\\Bundle\\ArticleBundle\\Form\\ChoiceList\\StatusList')
                                ->end()
                            ->end()
                        ->end()

                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addProxySection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('proxy')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                        ->children()
                            ->scalarNode('class')->defaultValue('Black\\Bundle\\PageBundle\\Proxy\\PageProxy')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addCategorySection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('category')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                        ->children()
                            ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')
                                    ->defaultValue('black_category_form')
                                ->end()
                                    ->scalarNode('type')
                                ->defaultValue('Black\\Bundle\\ArticleBundle\\Form\\Type\\CategoryType')
                                    ->end()
                                ->scalarNode('handler')
                                    ->defaultValue('Black\\Bundle\\ArticleBundle\\Form\\Handler\\CategoryFormHandler')
                                ->end()
                            ->end()
                        ->end()

                    ->end()
                ->end()
            ->end();
    }
}
