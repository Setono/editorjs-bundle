<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterBlockRenderersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('setono_editorjs.renderer')) {
            return;
        }

        $renderer = $container->getDefinition('setono_editorjs.renderer');

        /** @var string $id */
        foreach (array_keys($container->findTaggedServiceIds('setono_editorjs.block_renderer')) as $id) {
            $renderer->addMethodCall('addBlockRenderer', [new Reference($id)]);
        }
    }
}
