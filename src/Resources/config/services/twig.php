<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Setono\EditorJSBundle\Twig\Extension;
use Setono\EditorJSBundle\Twig\Runtime;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('setono_editorjs.twig.extension', Extension::class)
        ->tag('twig.extension')
    ;

    $services->set('setono_editorjs.twig.runtime', Runtime::class)
        ->args([
            service('setono_editorjs.parser'),
            service('setono_editorjs.renderer'),
        ])
        ->tag('twig.runtime')
        ->call('setLogger', [service('logger')->ignoreOnInvalid()])
    ;
};
