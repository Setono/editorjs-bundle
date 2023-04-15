# Symfony EditorJS Bundle

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Mutation testing][ico-infection]][link-infection]

This bundle integrates the [editorjs-php](https://github.com/Setono/editorjs-php) library into Symfony.

Instead of using the default block renderers in the library, this bundle creates a [TwigBlockRenderer](src/BlockRenderer/TwigBlockRenderer.php)
which renders all blocks as twig templates. This makes it very easy for you to override the rendered HTML for each block.

## Install

```shell
composer require setono/editorjs-bundle
```

## Usage

```php
<?php

use Setono\EditorJS\Parser\ParserInterface;
use Setono\EditorJS\Renderer\RendererInterface;

final class YourService
{
    public function __construct(
        private readonly ParserInterface $parser,
        private readonly RendererInterface $renderer
    ) {
    }

    public function __invoke(string $json): string
    {
        return $this->renderer->render($this->parser->parse($json));
    }
}
```

## Override rendered HTML

Each block has a corresponding Twig template inside the [block](src/Resources/views/block) directory.
The template for the `ListBlock` looks like this for example:

```twig
{# @var block \Setono\EditorJS\Block\ListBlock #}
<{{ block.tag }}>
{% for item in block.items %}
    <li>{{ item|raw }}</li>
{% endfor %}
</{{ block.tag }}>
```

Just as other Twig templates you can easily [override](https://symfony.com/doc/6.3/bundles/override.html#templates) these templates.

[ico-version]: https://poser.pugx.org/setono/editorjs-bundle/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/editorjs-bundle/v/unstable
[ico-license]: https://poser.pugx.org/setono/editorjs-bundle/license
[ico-github-actions]: https://github.com/Setono/EditorJSBundle/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/EditorJSBundle/branch/1.x/graph/badge.svg
[ico-infection]: https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FSetono%2FEditorJSBundle%2F1.x

[link-packagist]: https://packagist.org/packages/setono/editorjs-bundle
[link-github-actions]: https://github.com/Setono/EditorJSBundle/actions
[link-code-coverage]: https://codecov.io/gh/Setono/EditorJSBundle
[link-infection]: https://dashboard.stryker-mutator.io/reports/github.com/Setono/EditorJSBundle/1.x
