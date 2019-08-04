<?php

namespace Pixelbrackets\Html5MiniTemplate;

class Html5MiniTemplate {
    /**
     * The HTML5 template
     *
     * @var string
     */
    protected $markup = '';

    public function __construct()
    {
        $this->markup = file_get_contents(__DIR__ . '/../resources/template.html');
    }

    public function getMarkup() {
        return $this->markup;
    }
}
