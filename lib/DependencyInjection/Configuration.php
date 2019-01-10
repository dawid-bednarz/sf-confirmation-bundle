<?php
/**
 *  * Created by PhpStorm.
 * User: Dawid Bednarz( dawid@bednarz.pro )
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\DependencyInjection;

use DawBed\ComponentBundle\Configuration\Entity;
use DawBed\PHPToken\Token;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const NODE_TOKEN_TYPES = 'token_types';
    private const MAX_LENGTH_TOKEN_TYPE = 45;
    private const PATTERN_TOKEN_TYPE = 'a-z-_';

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode = $treeBuilder->root('dawbed_confirmation_bundle');

        $entity = new Entity($rootNode);
        $entity->new('token', Token::class);

        $rootNode
            ->children()
            ->arrayNode(self::NODE_TOKEN_TYPES)
            ->scalarPrototype()
            ->validate()
            ->ifTrue(function ($v) {
                preg_match(sprintf('/[^%s]/', self::PATTERN_TOKEN_TYPE), $v, $matched);
                return count($matched) > 0;
            })->thenInvalid(sprintf('Unexpect character in token type. Allowed "%s"', self::PATTERN_TOKEN_TYPE))
            ->end()
            ->validate()
            ->ifTrue(function ($v) {
                return strlen($v) > self::MAX_LENGTH_TOKEN_TYPE;
            })->thenInvalid(sprintf('Type name is too long. Maximum length %s characters', self::MAX_LENGTH_TOKEN_TYPE))
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}