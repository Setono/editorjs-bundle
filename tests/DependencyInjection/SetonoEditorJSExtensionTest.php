<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\EditorJS\Parser\Parser;
use Setono\EditorJS\Parser\ParserInterface;
use Setono\EditorJS\Renderer\Renderer;
use Setono\EditorJS\Renderer\RendererInterface;
use Setono\EditorJSBundle\BlockRenderer\TwigBlockRenderer;
use Setono\EditorJSBundle\DependencyInjection\SetonoEditorJSExtension;

/**
 * @covers \Setono\EditorJSBundle\DependencyInjection\SetonoEditorJSExtension
 */
final class SetonoEditorJSExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoEditorJSExtension(),
        ];
    }

    /**
     * @test
     */
    public function it_loads_services(): void
    {
        $this->load();

        $services = [
            ['id' => 'setono_editorjs.block_renderer.twig', 'class' => TwigBlockRenderer::class, 'tag' => 'setono_editorjs.block_renderer', 'tagAttributes' => ['priority' => '-100']],
            ['id' => ParserInterface::class, 'class' => Parser::class],
            ['id' => 'setono_editorjs.parser', 'class' => Parser::class],
            ['id' => RendererInterface::class, 'class' => Renderer::class],
            ['id' => 'setono_editorjs.renderer', 'class' => Renderer::class],
        ];

        foreach ($services as $service) {
            if (isset($service['tag'])) {
                $this->assertContainerBuilderHasServiceDefinitionWithTag($service['id'], $service['tag'], $service['tagAttributes'] ?? []);
            }

            $this->assertContainerBuilderHasService($service['id'], $service['class']);
        }
    }
}
