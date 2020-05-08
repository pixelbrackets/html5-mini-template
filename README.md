# HTML5 Mini Template

[![Version](https://img.shields.io/packagist/v/pixelbrackets/html5-mini-template.svg?style=flat-square)](https://packagist.org/packages/pixelbrackets/html5-mini-template/)
[![Build Status](https://img.shields.io/gitlab/pipeline/pixelbrackets/html5-mini-template?style=flat-square)](https://gitlab.com/pixelbrackets/html5-mini-template/pipelines)
[![Made With](https://img.shields.io/badge/made_with-php-blue?style=flat-square)](https://gitlab.com/pixelbrackets/html5-mini-template#requirements)
[![License](https://img.shields.io/badge/license-gpl--2.0--or--later-blue.svg?style=flat-square)](https://spdx.org/licenses/GPL-2.0-or-later.html)
[![Contribution](https://img.shields.io/badge/contributions_welcome-%F0%9F%94%B0-brightgreen.svg?labelColor=brightgreen&style=flat-square)](https://gitlab.com/pixelbrackets/html5-mini-template/-/blob/master/CONTRIBUTING.md)

The packages provides an HTML5 mini template for quick rendering of
status pages, TOC pages, or any other minimal single-serving site.

![Screenshot](./docs/screenshot.png)

## Vision

This package provides a single class to turn a text or HTML-snippet into a valid
HTML5 document.

This way it is possible to let an app return an HTML response without the need
to store a template file beforehand or initialize a full-blown template engine.

The package therefore does not have template variables, modifiers or parsers.
Three lines of code should be sufficient to wrap a given message into a valid
HTML document. See [»Usage«](#usage) for some examples.

The package follows the KISS principle.

## Webapp

This package is used on [html5example.com](https://html5example.com/).

If you are in need of an HTML document once only, then use a commandline tool
like HTTPie and run `http https://html5example.com > index.html`.

The webapp supports some [options](#options) of this package as well,
for example `http POST https://html5example.com title=Minimal-Template > index.html`
to pass a custom title.

## Requirements

* PHP

## Installation

Packagist Entry https://packagist.org/packages/pixelbrackets/html5-mini-template/

## Source

https://gitlab.com/pixelbrackets/html5-mini-template/

## Usage

1. Get the example template
   ```php
   $document = (new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate())->getMarkup();
   ```

1. Get template with custom content and write to file
   ```php
   $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
   $template->setContent('<h1>Index</h1><p>Nothing to see here</p>');
   file_put_contents('/var/www/example/index.html', $template->getMarkup());
   ```

1. Get template with custom content, an external link to a CSS framework
   output the document as response
   ```php
   $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
   $template->setStylesheet('skeleton');
   $template->setContent('<h1>Status</h1><p>All Systems Operational</p>');
   echo $template->getMarkup();
   ```

### Options

- `setContent()` the message to show, any HTML string to replace the main
  content of the document
- `setStylesheet()` may be a URL to any existing stylesheet *or*
  one of following reserved [keywords](https://gitlab.com/pixelbrackets/html5-mini-template/-/blob/1.2.1/src/Html5MiniTemplate.php#L18)
  which then creates a link to a CDN of the selected CSS framework
  - [`bootstrap`](https://github.com/twbs/bootstrap/)
  - [`milligram`](https://github.com/milligram/milligram/)
  - [`minicss`](https://github.com/Chalarangelo/mini.css/)
  - [`mui`](https://github.com/muicss/mui/)
  - [`picnic`](https://github.com/franciscop/picnic/)
  - [`skeleton`](https://github.com/dhg/Skeleton/)
- `setStylesheetMode()` either link the given stylesheet
  (`Html5MiniTemplate::STYLE_LINK`, default) or fetch its content and print
  it inline (`Html5MiniTemplate::STYLE_INLINE`).
- `setTitle()` the title is the first headline found in the document, unless
  it is overwritten with this option
- `setAdditionalMetadata()` any additional metadata like metatags or link
  references, for example a canonical link to avoid duplicate content - Usage
  of this option is an indicator that the given use case is too specific and
  switching to a template engine should be considered

## License

GNU General Public License version 2 or later

The GNU General Public License can be found at http://www.gnu.org/copyleft/gpl.html.

## Author

Dan Untenzu (<mail@pixelbrackets.de> / [@pixelbrackets](https://pixelbrackets.de))

## Changelog

See [./CHANGELOG.md](CHANGELOG.md)

## Contribution

This script is Open Source, so please use, patch, extend or fork it.

[Contributions](CONTRIBUTING.md) are welcome!
