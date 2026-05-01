<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Tests\Twig;

use Prophecy\PhpUnit\ProphecyTrait;
use Setono\EditorJS\Parser\ParserInterface;
use Setono\EditorJS\Renderer\RendererInterface;
use Setono\EditorJSBundle\Twig\Extension;
use Setono\EditorJSBundle\Twig\Runtime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\Test\IntegrationTestCase;
use Webmozart\Assert\Assert;

final class ExtensionTest extends IntegrationTestCase
{
    use ProphecyTrait;

    public function getRuntimeLoaders(): array
    {
        $parser = $this->prophesize(ParserInterface::class);
        $renderer = $this->prophesize(RendererInterface::class);

        $runtimeLoader = new class($parser->reveal(), $renderer->reveal()) implements RuntimeLoaderInterface {
            public function __construct(
                private readonly ParserInterface $parser,
                private readonly RendererInterface $renderer,
            ) {
            }

            /**
             * @param string $class
             */
            public function load($class): Runtime
            {
                Assert::same($class, Runtime::class);

                return new Runtime($this->parser, $this->renderer);
            }
        };

        return [$runtimeLoader];
    }

    public function getExtensions(): array
    {
        return [
            new Extension(),
        ];
    }

    protected static function getFixturesDirectory(): string
    {
        return __DIR__ . '/Fixtures/';
    }
}
