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
use Doctrine\ORM\Version;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DoctrineResolveTargetEntityPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');

        $definition->addMethodCall('addResolveTargetEntity', [
            TokenInterface::class,
            ClassProvider::get(AbstractToken::class),
            [],
        ]);

        if (version_compare(Version::VERSION, '2.5.0-DEV') < 0) {
            $definition->addTag('doctrine.event_listener', ['event' => 'loadClassMetadata']);
        } else {
            $definition->addTag('doctrine.event_subscriber', ['connection' => 'default']);
        }
    }
}