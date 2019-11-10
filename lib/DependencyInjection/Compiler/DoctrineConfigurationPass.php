<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\DependencyInjection\Compiler;

use DawBed\ConfirmationBundle\Entity\AbstractToken;
use DawBed\ConfirmationBundle\Entity\TokenInterface;
use DawBed\PHPClassProvider\ClassProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DoctrineConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $this->targetEntities($container);
    }

    private function targetEntities(ContainerBuilder $container): void
    {
        $definition = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');
        $definition->addMethodCall('addResolveTargetEntity', [
            TokenInterface::class,
            ClassProvider::get(AbstractToken::class),
            [],
        ]);
        $definition->addTag('doctrine.event_subscriber', ['connection' => 'default']);
    }
}