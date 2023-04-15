<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Exception;

use Setono\EditorJS\Exception\RendererExceptionInterface;

final class TwigRenderException extends \RuntimeException implements RendererExceptionInterface
{
    public static function fromThrowable(string $template, \Throwable $e): self
    {
        return new self(sprintf(
            'There was an error rendering template %s: %s',
            $template,
            $e->getMessage(),
        ), 0, $e);
    }
}
