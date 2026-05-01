<?php

declare(strict_types=1);

use Setono\EditorJS\Renderer\Renderer;
use Setono\EditorJS\Renderer\RendererInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set('setono_editorjs.renderer', Renderer::class)
        ->call('setLogger', [service('logger')->ignoreOnInvalid()])
        ->call('throwOnUnsupported', ['%kernel.debug%'])
    ;

    $services->alias(RendererInterface::class, 'setono_editorjs.renderer');
};
