<?php

declare(strict_types=1);

/*
 * This file is part of the CKEditorSonataMediaBundlefork package.
 *
 * (c) La Coopérative des Tilleuls <contact@les-tilleuls.coop>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TWorks\Bundle\CKEditorSonataMediaBundlefork\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @author Kévin Dunglas <kevin@les-tilleuls.coop>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('tworks_ck_editor_sonata_media');
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        }

        $rootNode
            ->children()
                ->arrayNode('templates')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('layout')->defaultValue('@TWorksCKEditorSonataMedia/layout.html.twig')->end()
                        ->scalarNode('browser')->defaultValue('@TWorksCKEditorSonataMedia/MediaAdmin/browser.html.twig')->end()
                        ->scalarNode('upload')->defaultValue('@TWorksCKEditorSonataMedia/MediaAdmin/upload.html.twig')->end()
                    ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
