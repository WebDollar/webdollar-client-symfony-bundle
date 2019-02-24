<?php

namespace WebDollar\WebDollarClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use WebDollar\Client\WebDollarClient;

/**
 * Class WebDollarClientExtension
 * @package WebDollar\WebDollarClientBundle\DependencyInjection
 */
class WebDollarClientExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

//        // Register default services
//        foreach ($config['classes'] as $service => $class) {
//            if (!empty($class)) {
//                $container->register(sprintf('webdollar.%s.default', $service), $class);
//            }
//        }

        $this->configureClients($container, $config);
    }

    /**
     * Configure client services.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    private function configureClients(ContainerBuilder $container, array $config)
    {
        $first   = null;
        $clients = [];

        foreach ($config['clients'] as $name => $arguments) {
            if (null === $first) {
                // Save the name of the first configured client.
                $first = $name;
            }

            $this->configureClient($container, $name, $arguments);
            $clients[] = $name;
        }

        // If we have clients configured
        if (null !== $first) {
            // If we do not have a client named 'default'
            if (!isset($config['clients']['default'])) {
                // Alias the first client to webdollar.client.default
                $container->setAlias('webdollar.client.default', 'webdollar.client.'.$first);
            }
        }

        $container->getDefinition('webdollar.client_manager')
            ->replaceArgument(0, array_map(function($sClientName) {
                return new Reference(sprintf('webdollar.client.%s', $sClientName));
            }, $clients));
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $clientName
     * @param array            $arguments
     */
    private function configureClient(ContainerBuilder $container, $clientName, array $arguments)
    {
        $serviceId = 'webdollar.client.'.$clientName;

        if (empty($arguments['service']))
        {
            $container
                ->register($serviceId, WebDollarClient::class)
                ->addArgument($arguments['config'])
                ->setPublic(false);
        }
        else
        {
            $container->setAlias($serviceId, new Alias($arguments['service'], false));
        }
    }
}
