<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\DependencyInjection;

use DawBed\ConfirmationBundle\Service\SupportTypeService;
use DawBed\PHPClassProvider\ClassProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ConfirmationExtension extends Extension implements PrependExtensionInterface
{
    const ALIAS = 'dawbed_confirmation_bundle';

    public function prepend(ContainerBuilder $container): void
    {
        $loader = $this->prepareLoader($container);
        $loader->load('packages/component_bundle.yaml');
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $container->setParameter('bundle_dir', dirname(__DIR__));
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = $this->prepareLoader($container);
        $loader->load('services.yaml');
        $this->prepareSupportTypeService($configs, $container);
        $this->prepareEntityService($config['entities']);
    }

    public function getAlias(): string
    {
        return self::ALIAS;
    }

    private function prepareLoader(ContainerBuilder $containerBuilder): YamlFileLoader
    {
        return new YamlFileLoader($containerBuilder, new FileLocator(dirname(__DIR__) . '/Resources/config'));
    }

    private function prepareSupportTypeService(array $configs, ContainerBuilder $container): void
    {
        $container->setDefinition(SupportTypeService::class, new Definition(SupportTypeService::class, [
            $this->getTypesToken($configs)
        ]));
    }

    private function prepareEntityService(array $entities): void
    {
        foreach ($entities as $name => $class) {
            ClassProvider::add($name,$class);
        }
    }

    private function getTypesToken(array $configs): array
    {
        $types = [];

        foreach ($configs as $config) {
            if (array_key_exists(Configuration::NODE_TOKEN_TYPES, $config)) {
                foreach ($config[Configuration::NODE_TOKEN_TYPES] as $type) {
                    if (in_array($type, $types)) {
                        throw new \Exception(sprintf('Duplicate token type "%s"', $type));
                    }
                    $types[] = $type;
                }
            }
        }
        return $types;
    }

}