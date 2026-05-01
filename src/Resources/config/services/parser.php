<?php

declare(strict_types=1);

use Setono\EditorJS\Parser\Parser;
use Setono\EditorJS\Parser\ParserInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('setono_editorjs.parser', Parser::class);

    $services->alias(ParserInterface::class, 'setono_editorjs.parser');
};
