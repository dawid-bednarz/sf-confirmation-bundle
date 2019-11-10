<?php
/**
 *  * User: Dawid Bednarz( dawid@bednarz.pro )
 *
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle;

use DawBed\ComponentBundle\DependencyInjection\ChildrenBundle\ComponentBundleInterface;
use DawBed\ConfirmationBundle\DependencyInjection\Compiler\DoctrineConfigurationPass;
use DawBed\ConfirmationBundle\DependencyInjection\ConfirmationExtension;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use DawBed\ConfirmationBundle\Event\Events;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ConfirmationBundle extends Bundle implements ComponentBundleInterface
{
    public function getContainerExtension()
    {
        return new ConfirmationExtension;
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DoctrineConfigurationPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 1000);
        $this->addRegisterMappingsPass($container);
    }

    public static function getEvents(): ?string
    {
        return Events::class;
    }

    public static function getAlias(): string
    {
        return ConfirmationExtension::ALIAS;
    }

    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver([
            realpath(__DIR__ . '/Resources/config/schema') => 'DawBed\ConfirmationBundle\Entity',
        ]));
    }
}