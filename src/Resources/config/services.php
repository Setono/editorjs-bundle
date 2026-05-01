<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $container->import('services/block_renderer.php');
    $container->import('services/parser.php');
    $container->import('services/renderer.php');
    $container->import('services/twig.php');
};
