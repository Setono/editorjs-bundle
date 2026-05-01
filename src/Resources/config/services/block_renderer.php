<?php

declare(strict_types=1);

use Setono\EditorJSBundle\BlockRenderer\TwigBlockRenderer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('setono_editorjs.block_renderer.twig', TwigBlockRenderer::class)
        ->args([service('twig')])
        ->tag('setono_editorjs.block_renderer', ['priority' => -100])
    ;
};
