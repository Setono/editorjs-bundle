<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Setono\EditorJSBundle\BlockRenderer\TwigBlockRenderer;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('setono_editorjs.block_renderer.twig', TwigBlockRenderer::class)
        ->args([service('twig')])
        ->tag('setono_editorjs.block_renderer', ['priority' => -100])
    ;
};
