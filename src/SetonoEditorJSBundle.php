<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle;

use Setono\EditorJSBundle\DependencyInjection\Compiler\RegisterBlockHydratorsPass;
use Setono\EditorJSBundle\DependencyInjection\Compiler\RegisterBlockRenderersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SetonoEditorJSBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterBlockHydratorsPass());
        $container->addCompilerPass(new RegisterBlockRenderersPass());
    }
}
