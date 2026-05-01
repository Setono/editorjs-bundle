<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Setono\EditorJS\Renderer\Renderer;
use Setono\EditorJS\Renderer\RendererInterface;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('setono_editorjs.renderer', Renderer::class)
        ->call('setLogger', [service('logger')->ignoreOnInvalid()])
        ->call('throwOnUnsupported', ['%kernel.debug%'])
    ;

    $services->alias(RendererInterface::class, 'setono_editorjs.renderer');
};
