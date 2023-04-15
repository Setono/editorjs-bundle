<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterBlockRenderersPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    private const RENDERER_SERVICE_ID = 'setono_editorjs.renderer';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(self::RENDERER_SERVICE_ID)) {
            return;
        }

        $renderer = $container->getDefinition(self::RENDERER_SERVICE_ID);

        foreach ($this->findAndSortTaggedServices('setono_editorjs.block_renderer', $container) as $service) {
            $renderer->addMethodCall('add', [$service]);
        }
    }
}
