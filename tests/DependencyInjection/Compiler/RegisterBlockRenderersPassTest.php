<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Setono\EditorJSBundle\DependencyInjection\Compiler\RegisterBlockRenderersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @covers \Setono\EditorJSBundle\DependencyInjection\Compiler\RegisterBlockRenderersPass
 */
final class RegisterBlockRenderersPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterBlockRenderersPass());
    }

    /**
     * @test
     */
    public function it_registers_block_renderers(): void
    {
        $renderer = new Definition();
        $this->setDefinition('setono_editorjs.renderer', $renderer);

        $blockRendererDefinition = new Definition();
        $blockRendererDefinition->addTag('setono_editorjs.block_renderer');
        $this->setDefinition('block_renderer', $blockRendererDefinition);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'setono_editorjs.renderer',
            'add',
            [
                new Reference('block_renderer'),
            ],
        );
    }

    /**
     * @test
     */
    public function it_does_not_do_anything_if_renderer_is_not_present(): void
    {
        $blockRendererDefinition = new Definition();
        $blockRendererDefinition->addTag('setono_editorjs.block_renderer');
        $this->setDefinition('block_renderer', $blockRendererDefinition);

        $this->compile();

        $this->assertContainerBuilderNotHasService('setono_editorjs.renderer');
    }
}
