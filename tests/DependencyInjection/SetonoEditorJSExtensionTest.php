<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
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
    public function it_can_load(): void
    {
        $this->load();

        self::assertTrue(true);
    }
}
