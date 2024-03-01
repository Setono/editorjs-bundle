<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Twig;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Setono\EditorJS\Parser\ParserInterface;
use Setono\EditorJS\Renderer\RendererInterface;
use Twig\Extension\RuntimeExtensionInterface;

final class Runtime implements RuntimeExtensionInterface, LoggerAwareInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private readonly ParserInterface $parser,
        private readonly RendererInterface $renderer,
    ) {
        $this->logger = new NullLogger();
    }

    public function render(string $json): string
    {
        try {
            return $this->renderer->render($this->parser->parse($json));
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
        }

        return '';
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
