<?php

use Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate;
use PHPUnit\Framework\TestCase;

class Html5MiniTemplateTest extends TestCase
{
    public function testExampleTemplate()
    {
        $document = \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate::getTemplate();

        $this->assertNotEmpty($document);
        $this->assertStringContainsString('<!DOCTYPE html>', $document);
        $this->assertStringContainsString('<h1>HTML5 Example Page</h1>', $document);
        $this->assertStringContainsString('scripts.js', $document);
        $this->assertStringContainsString('stylesheet.css', $document);
    }

    public function testContentOverwrite()
    {
        $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();

        $template->setContent('<h1>Status</h1><p>All Systems Operational</p>');
        $document = $template->getMarkup();
        $this->assertStringNotContainsString('HTML5 Example Page', $document);
        $this->assertStringContainsString('<h1>Status</h1>', $document);
    }

    public function testTitleOverwrite()
    {
        $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();

        // automatic: first headline
        $template->setContent('<h1>Index</h1>');
        $document = $template->getMarkup();
        $this->assertStringNotContainsString('HTML5 Example Page', $document);
        $this->assertStringContainsString('<h1>Index</h1>', $document);
        $this->assertStringContainsString('<title>Index</title>', $document);

        // manually: set title
        $template->setTitle('Redirect');
        $document = $template->getMarkup();
        $this->assertStringContainsString('<h1>Index</h1>', $document);
        $this->assertStringNotContainsString('<title>Index</title>', $document);
        $this->assertStringContainsString('<title>Redirect</title>', $document);
    }

    public function testStylesheetOverwrite()
    {
        $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
        $document = $template->getMarkup();
        $this->assertStringContainsString('stylesheet.css', $document);

        $template->setStylesheet('skeleton');
        $document = $template->getMarkup();
        $this->assertStringContainsString('skeleton.css', $document);

        $template->setStylesheet('');
        $document = $template->getMarkup();
        $this->assertStringNotContainsString('stylesheet.css', $document);
    }

    public function testAdditionalMetadata()
    {
        $template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
        $template->setAdditionalMetadata('<link rel="canonical" href="https://html5example.com/">');
        $document = $template->getMarkup();
        $this->assertStringContainsString('canonical', $document);
    }
}