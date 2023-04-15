<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Setono\EditorJSBundle\Exception\TwigRenderException;

/**
 * @covers \Setono\EditorJSBundle\Exception\TwigRenderException
 */
final class TwigRenderExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function the_message_is_populated(): void
    {
        $inner = new \RuntimeException('The template does not exist');
        $e = TwigRenderException::fromThrowable('template.html.twig', $inner);

        self::assertSame('There was an error rendering template template.html.twig: The template does not exist', $e->getMessage());
        self::assertSame($inner, $e->getPrevious());
        self::assertSame(0, $e->getCode());
    }
}
