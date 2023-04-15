<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Tests\BlockRenderer;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\EditorJS\Block\Block;
use Setono\EditorJSBundle\BlockRenderer\TwigBlockRenderer;
use Setono\EditorJSBundle\Exception\TwigRenderException;
use Twig\Environment;
use Twig\Error\LoaderError;

/**
 * @covers \Setono\EditorJSBundle\BlockRenderer\TwigBlockRenderer
 */
final class TwigBlockRendererTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_renders(): void
    {
        $twig = $this->prophesize(Environment::class);
        $twig->render('@SetonoEditorJS/block/simple_image.html.twig')->shouldBeCalledOnce()->willReturn('');

        $renderer = new TwigBlockRenderer($twig->reveal());
        $renderer->render(new SimpleImageBlock('id'));
    }

    /**
     * @test
     */
    public function it_supports_all_blocks(): void
    {
        $renderer = new TwigBlockRenderer($this->prophesize(Environment::class)->reveal());
        self::assertTrue($renderer->supports(new SimpleImageBlock('id')));
    }

    /**
     * @test
     */
    public function it_throws_twig_render_exception_if_the_template_cannot_be_rendered(): void
    {
        $this->expectException(TwigRenderException::class);

        $twig = $this->prophesize(Environment::class);
        $twig->render('@SetonoEditorJS/block/simple_image.html.twig')->willThrow(new LoaderError('The template does not exist'));

        $renderer = new TwigBlockRenderer($twig->reveal());
        $renderer->render(new SimpleImageBlock('id'));
    }
}

final class SimpleImageBlock extends Block
{
}
