<?php

namespace Pixelbrackets\Html5MiniTemplate;

class Html5MiniTemplate {
    /**
     * The HTML5 template
     *
     * @var string
     */
    protected $markup = '';

    /**
     * The documents main content
     *
     * @var string
     */
    protected $content = '';

    /**
     * Mini Template
     *
     * @return string
     */
    public function __construct()
    {
        $this->markup = file_get_contents(__DIR__ . '/../resources/template.html');
    }

    /**
     * Process all changes like custom content
     *
     * @param $text Markup for document body
     * @return string
     */
    protected function parseMarkup() {
        $markup = $this->markup;
        if (false === empty($this->content)) {
            $markup = preg_replace('/<body>(.*?)<\/body>/is', '<body>' . $this->content . '</body>', $markup);
        }
        return $markup;
    }

    /**
     * Get markup of HTML5 document
     *
     * @return string
     */
    public function getMarkup() {
        return $this->parseMarkup();
    }

    /**
     * Set markup for document body
     *
     * @param string $text Markup for document body
     * @return void
     */
    public function setContent($text) {
        $this->content = $text;
    }
}
