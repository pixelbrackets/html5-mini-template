# HTML5 Mini Template

[![Version](https://img.shields.io/packagist/v/pixelbrackets/html5-mini-template.svg?style=flat-square)](https://packagist.org/packages/pixelbrackets/html5-mini-template/)
[![Build Status](https://img.shields.io/gitlab/pipeline/pixelbrackets/html5-mini-template?style=flat-square)](https://gitlab.com/pixelbrackets/html5-mini-template/pipelines)
[![Made With](https://img.shields.io/badge/made_with-php-blue?style=flat-square)](https://gitlab.com/pixelbrackets/html5-mini-template#requirements)
[![License](https://img.shields.io/badge/license-gpl--2.0--or--later-blue.svg?style=flat-square)](https://spdx.org/licenses/GPL-2.0-or-later.html)
[![Contribution](https://img.shields.io/badge/contributions_welcome-%F0%9F%94%B0-brightgreen.svg?labelColor=brightgreen&style=flat-square)](https://gitlab.com/pixelbrackets/html5-mini-template/-/blob/master/CONTRIBUTING.md)

HTML5 Mini Template for quick rendering of status pages, TOC pages,
or any other minimal single-serving site.

![Screenshot](./docs/screenshot.png)

_⭐ You like this package? Please star it or send a tweet. ⭐_

## Vision

This package provides a single class to turn a message or HTML-snippet into
a valid HTML5 document.

This way it is possible to let an app return an HTML response without the need
to store a template file beforehand or initialize a full-blown template engine.

The package therefore does not have template variables or modifiers.
Two lines of code should be sufficient to wrap a given text into a valid
HTML document. One more to add a link to fancy stylesheet.

See [»Usage«](#usage) for some examples.

The package follows the KISS principle.

## Webapp

This package is used on [html5example.com](https://html5example.com/).

If you are in need of a boilerplate HTML document once only, then you may use a
commandline tool like HTTPie and run
`http https://html5example.com > index.html` to save a template file.

The webapp supports some [options](#options) of this package as well,
for example
`http POST https://html5example.com title=Minimal-Template > index.html`
to pass a custom title.

## Requirements

- PHP

## Installation

Packagist Entry https://packagist.org/packages/pixelbrackets/html5-mini-template/

## Source

https://gitlab.com/pixelbrackets/html5-mini-template/

Mirror https://github.com/pixelbrackets/html5-mini-template/ (Issues & Pull Requests
mirrored to GitLab)

## Demo

⌨️ [`php tests/demo.php`](./tests/demo.php).

## Usage

1. Wrap a message into a HTML5 document, return to a PSR-7 implementation
   ```php
   $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
   $template->setContent('<h1>Status</h1><p>All Systems Operational</p>');
   return $template->getMarkup();
   ```

1. Wrap a message, use a preconfigured CSS framework CDN
   (see [»options«](#options) for a list of supported frameworks),
   and save the document into a file
   ```php
   $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
   $template->setStylesheet('skeleton');
   $template->setContent('<h1>Index</h1><p>Nothing to see here</p>');
   file_put_contents('/var/www/example/index.html', $template->getMarkup());
   ```

1. Wrap a message, set your own stylesheet URL, set a title,
   output the document
   ```php
   $template = (new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate())
       ->setStylesheet('/assets/styles.css')
       ->setTitle('Index')
       ->setContent('<h1>TOC</h1><ul><li>a</li><li>b</li></ul>');
   echo $template->getMarkup();
   ```

1. Get the boilerplate example template only (👉 or use the [Webapp](#webapp))
   ```php
   echo \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate::getTemplate();
   ```

### Options

- `setContent()` (*string*) the message to show, any HTML string to set
  the main content of the document – if empty, then a
  [boilerplate](https://html5example.com/) example content is used instead
  - 💭 You work with Markdown content? Use the drop-in replacement package
    [pixelbrackets/markdown-mini-page](https://packagist.org/packages/pixelbrackets/markdown-mini-page/)
- `setStylesheet()` (*string*) may be a URL to any existing stylesheet *or*
  one of following reserved keywords – each keyword creates a link to a CDN
  of the associated CSS framework
  - `barebone` ([Barebone Stylesheet](https://github.com/pixelbrackets/barebone-stylesheet/))
  - `bootstrap` ([Bootstrap](https://github.com/twbs/bootstrap/))
  - `gfm` ([GitHub Flavored Markdown Stylesheet](https://github.com/pixelbrackets/gfm-stylesheet/))
  - `milligram` ([Milligram](https://github.com/milligram/milligram/))
  - `minicss` ([mini.css](https://github.com/Chalarangelo/mini.css/))
  - `mui` ([MUI - Material Design CSS Framework](https://github.com/muicss/mui/))
  - `mvp` ([MVP.css](https://github.com/andybrewer/mvp/))
  - `picnic` ([Picnic CSS](https://github.com/franciscop/picnic/))
  - `skeleton` ([Skeleton](https://github.com/dhg/Skeleton/))
- `setStylesheetMode()` (*string*) switch between a link to the given stylesheet
  (using the constant `Html5MiniTemplate::STYLE_LINK`, this is the default mode)
  or fetch the stylesheet file content and print it inline
  (using the constant `Html5MiniTemplate::STYLE_INLINE`)
- `setTitle()` (*string*) the document title – if empty, then the first H1
  headline found in the main content is used as title instead
- `setAdditionalMetadata()` (*string*) any additional metadata like metatags,
  custom styles or link references like a canonical link
  - ⚠️ Usage of this option is an indicator that the given use case is too
    specific and switching to a template engine like the minimal
    [slim/php-view](https://packagist.org/packages/slim/php-view) or the
    powerfull [twig/twig](https://packagist.org/packages/twig/twig)
    should be considered

## License

GNU General Public License version 2 or later

The GNU General Public License can be found at http://www.gnu.org/copyleft/gpl.html.

## Author

Dan Untenzu (<mail@pixelbrackets.de> / [@pixelbrackets](https://pixelbrackets.de))

## Changelog

See [CHANGELOG.md](./CHANGELOG.md)

## Contribution

This script is Open Source, so please use, share, patch, extend or fork it.

[Contributions](./CONTRIBUTING.md) are welcome!

## Feedback

Please send some [feedback](https://pixelbrackets.de/) and share how this
package has proven useful to you or how you may help to improve it.
