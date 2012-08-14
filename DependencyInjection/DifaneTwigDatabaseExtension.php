<?php

namespace Difane\Bundle\TwigDatabaseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DifaneTwigDatabaseExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('difane.bundle.twigdatabase.twig.loader.database.autocreatetemplates', $config['auto_create_templates']);

        if(true == $config['sonata_admin']['enabled'])
        {
            $loader->load('sonata-admin.xml');
            $container->setParameter('difane.bundle.twigdatabase.admin.template.group', $config['sonata_admin']['group']);
            $container->setParameter('difane.bundle.twigdatabase.admin.template.label', $config['sonata_admin']['label']);
        }
    }
}
