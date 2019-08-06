# HTML5 Mini Template

[![Packagist](https://img.shields.io/packagist/v/pixelbrackets/html5-mini-template.svg)](https://packagist.org/packages/pixelbrackets/html5-mini-template/)

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
  keywords which links to a CDN of the selected CSS framework 
  (eg. »[skeleton](http://getskeleton.com/)«).
- `setTitle` changes the title of the document

## License

GNU General Public License version 2 or later

The GNU General Public License can be found at http://www.gnu.org/copyleft/gpl.html.

## Author

Dan Untenzu (<mail@pixelbrackets.de> / [@pixelbrackets](https://pixelbrackets.de))

## Changelog

See [./CHANGELOG.md](CHANGELOG.md)

## Contribution

This script is Open Source, so please use, patch, extend or fork it.
