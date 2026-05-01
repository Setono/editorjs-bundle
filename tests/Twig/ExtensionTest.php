<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Tests\Twig;

use PHPUnit\Framework\Attributes\DataProvider;
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

    /**
     * @param mixed $file
     * @param mixed $message
     * @param mixed $condition
     * @param mixed $templates
     * @param mixed $exception
     * @param mixed $outputs
     * @param mixed $deprecation
     */
    #[DataProvider('provideIntegrationTests')]
    public function testIntegration($file, $message, $condition, $templates, $exception, $outputs, $deprecation = ''): void
    {
        $this->doIntegrationTest($file, $message, $condition, $templates, $exception, $outputs, $deprecation);
    }

    /**
     * @param mixed $file
     * @param mixed $message
     * @param mixed $condition
     * @param mixed $templates
     * @param mixed $exception
     * @param mixed $outputs
     * @param mixed $deprecation
     */
    #[DataProvider('provideLegacyIntegrationTests')]
    public function testLegacyIntegration($file, $message, $condition, $templates, $exception, $outputs, $deprecation = ''): void
    {
        $this->doIntegrationTest($file, $message, $condition, $templates, $exception, $outputs, $deprecation);
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: string, 3: array<string, string>, 4: string|false, 5: array<int, array<int, mixed>>, 6: string}>
     */
    public static function provideIntegrationTests(): array
    {
        return self::loadFixtures(false);
    }

    /**
     * @return array<int|string, array{0: string, 1: string, 2: string, 3: array<string, string>, 4: string|false, 5: array<int, array<int, mixed>>, 6: string}>
     */
    public static function provideLegacyIntegrationTests(): array
    {
        $tests = self::loadFixtures(true);

        if ([] === $tests) {
            return [['not', '-', '', [], '', [], '']];
        }

        return $tests;
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: string, 3: array<string, string>, 4: string|false, 5: array<int, array<int, mixed>>, 6: string}>
     */
    private static function loadFixtures(bool $legacy): array
    {
        $fixturesDir = realpath(static::getFixturesDirectory());
        Assert::string($fixturesDir);

        $tests = [];

        /** @var \SplFileInfo $file */
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($fixturesDir), \RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            if (1 !== preg_match('/\.test$/', $file->getPathname())) {
                continue;
            }

            $realpath = $file->getRealPath();
            Assert::string($realpath);

            if ($legacy xor str_contains($realpath, '.legacy.test')) {
                continue;
            }

            $contents = file_get_contents($realpath);
            Assert::string($contents);

            if (1 === preg_match('/--TEST--\s*(.*?)\s*(?:--CONDITION--\s*(.*))?\s*(?:--DEPRECATION--\s*(.*?))?\s*((?:--TEMPLATE(?:\(.*?\))?--(?:.*?))+)\s*(?:--DATA--\s*(.*))?\s*--EXCEPTION--\s*(.*)/sx', $contents, $match)) {
                $message = $match[1];
                $condition = $match[2];
                $deprecation = $match[3];
                $templates = self::parseTemplates($match[4]);
                $exception = $match[6];
                $outputs = [[null, $match[5], null, '']];
            } elseif (1 === preg_match('/--TEST--\s*(.*?)\s*(?:--CONDITION--\s*(.*))?\s*(?:--DEPRECATION--\s*(.*?))?\s*((?:--TEMPLATE(?:\(.*?\))?--(?:.*?))+)--DATA--.*?--EXPECT--.*/s', $contents, $match)) {
                $message = $match[1];
                $condition = $match[2];
                $deprecation = $match[3];
                $templates = self::parseTemplates($match[4]);
                $exception = false;
                preg_match_all('/--DATA--(.*?)(?:--CONFIG--(.*?))?--EXPECT--(.*?)(?=\-\-DATA\-\-|$)/s', $contents, $outputs, \PREG_SET_ORDER);
            } else {
                throw new \InvalidArgumentException(sprintf('Test "%s" is not valid.', str_replace($fixturesDir . '/', '', $realpath)));
            }

            $relativePath = str_replace($fixturesDir . '/', '', $realpath);
            $tests[$relativePath] = [$relativePath, $message, $condition, $templates, $exception, $outputs, $deprecation];
        }

        return $tests;
    }
}
