<?php

namespace Anh\SiteBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AnhSiteExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('assetic', array(
            'assets' => array(
                'jquery_js' => array(
                    'inputs' => array(
                        'bundles/anhsite/components/jquery/dist/jquery.min.js',
                    )
                ),
                'jquery_ui_js' => array(
                    'inputs' => array(
                        'bundles/anhsite/components/jqueryui/ui/minified/jquery-ui.min.js',
                    )
                ),
                'jquery_ui_css' => array(
                    'inputs' => array(
                        'bundles/anhsite/components/jqueryui/themes/smoothness/jquery-ui.min.css',
                    ),
                    'filters' => array(
                        'cssrewrite'
                    )
                )
            ),
            'bundles' => array(
                'AnhSiteBundle'
            )
        ));

        $container->prependExtensionConfig('sp_bower', array(
            'assetic' => array(
                'enabled' => false
            ),
            'bundles' => array(
                'AnhSiteBundle' => null
            )
        ));
    }
}
