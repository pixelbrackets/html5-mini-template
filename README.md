# HTML5 Mini Template

[![Version](https://img.shields.io/packagist/v/pixelbrackets/html5-mini-template.svg?style=flat-square)](https://packagist.org/packages/pixelbrackets/html5-mini-template/)
[![Build Status](https://img.shields.io/gitlab/pipeline/pixelbrackets/html5-mini-template?style=flat-square)](https://gitlab.com/pixelbrackets/html5-mini-template/pipelines)
[![Made With](https://img.shields.io/badge/made_with-php-blue?style=flat-square)](https://gitlab.com/pixelbrackets/html5-mini-template#requirements)
[![License](https://img.shields.io/badge/license-gpl--2.0--or--later-blue.svg?style=flat-square)](https://spdx.org/licenses/GPL-2.0-or-later.html)
[![Contribution](https://img.shields.io/badge/contributions_welcome-%F0%9F%94%B0-brightgreen.svg?labelColor=brightgreen&style=flat-square)](https://gitlab.com/pixelbrackets/html5-mini-template/-/blob/master/CONTRIBUTING.md)

The packages provides an HTML5 mini template for quick rendering of 
status pages, TOC pages, or any other minimal single-serving site.

![Screenshot](./docs/screenshot.png)

## Requirements

* PHP

## Installation

Packagist Entry https://packagist.org/packages/pixelbrackets/html5-mini-template/

## Source

https://gitlab.com/pixelbrackets/html5-mini-template/

## Usage

1. Get the example template
   ```php
   $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
   echo $template->getMarkup();
   ```

1. Get template with custom content and an external link to an CSS framework
   ```php
   $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
   $template->setStylesheet('skeleton');
   $template->setContent('<h1>Status</h1><p>All Systems Operational</p>');
   echo $template->getMarkup();
   ```

### Options

- `setContent` any HTML string to replace the main content of the document
- `setStylesheet` may be a URL to an existing stylesheet or one of the reserved
  [keywords](https://gitlab.com/pixelbrackets/html5-mini-template/-/blob/1.2.1/src/Html5MiniTemplate.php#L18)
  which links to a CDN of the selected CSS framework
  (eg. »[skeleton](http://getskeleton.com/)«).
- `setStylesheetMode` either link the given stylesheet
  (`Html5MiniTemplate::STYLE_LINK`) or fetch its content render it inline
  (`Html5MiniTemplate::STYLE_INLINE`).
- `setTitle` changes the title of the document (fallback is the first headline
  found in the document)

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
