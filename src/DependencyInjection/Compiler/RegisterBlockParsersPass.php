<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterBlockParsersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('setono_editorjs.parser')) {
            return;
        }

        $parser = $container->getDefinition('setono_editorjs.parser');

        /** @var string $id */
        foreach (array_keys($container->findTaggedServiceIds('setono_editorjs.block_parser')) as $id) {
            $parser->addMethodCall('addBlockParser', [new Reference($id)]);
        }
    }
}
