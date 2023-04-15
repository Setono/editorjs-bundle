<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\BlockRenderer;

use Setono\EditorJS\Block\Block;
use Setono\EditorJS\BlockRenderer\BlockRendererInterface;
use Setono\EditorJSBundle\Exception\TwigRenderException;
use function Symfony\Component\String\u;
use Twig\Environment;

final class TwigBlockRenderer implements BlockRendererInterface
{
    public function __construct(private readonly Environment $twig)
    {
    }

    public function render(Block $block): string
    {
        $reflectionClass = new \ReflectionClass($block);

        $blockName = u($reflectionClass->getShortName())
            ->snake()
            ->trimSuffix('_block')
            ->toString()
        ;

        $template = sprintf('@SetonoEditorJS/block/%s.html.twig', $blockName);

        try {
            return $this->twig->render($template, [
                'block' => $block,
            ]);
        } catch (\Throwable $e) {
            throw TwigRenderException::fromThrowable($template, $e);
        }
    }

    public function supports(Block $block): bool
    {
        return true;
    }
}
