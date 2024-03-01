<?php

declare(strict_types=1);

namespace Setono\EditorJSBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class Extension extends AbstractExtension
{
    /**
     * @return list<TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('editorjs_render', [Runtime::class, 'render'], ['is_safe' => ['html']]),
        ];
    }
}
