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
     * Stylesheet preselection
     *
     * @var array
     */
    protected $listOfStylesheets = [
        'bootstrap' => 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@4.3/dist/css/bootstrap.min.css',
        'example' => '/assets/css/stylesheet.css?v=1',
        'milligram' => 'https://cdn.jsdelivr.net/gh/milligram/milligram@1.3/dist/milligram.min.css',
        'mini.css' => 'https://cdn.jsdelivr.net/gh/Chalarangelo/mini.css@3.0/dist/mini-default.min.css',
        'mui' => 'https://cdn.jsdelivr.net/gh/muicss/mui@0.9/packages/cdn/css/mui.min.css',
        'picnic' => 'https://cdn.jsdelivr.net/gh/franciscop/picnic@6.4/releases/plugins.min.css',
        'skeleton' => 'https://cdn.jsdelivr.net/gh/dhg/Skeleton@2.0.4/css/skeleton.css',
    ];

    /**
     * The document title
     *
     * @var array
     */
    protected $title = '';

    /**
     * The linked stylesheet
     *
     * @var array
     */
    protected $stylesheet = 'example';

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
     * @param string $text Markup for document body
     * @return string
     */
    protected function parseMarkup() {
        $markup = $this->markup;

        if (false === empty($this->title)) {
            $markup = preg_replace('/HTML5 Example Page/', $this->title, $markup);
        }

        $stylesheet = '';
        if (false === empty($this->stylesheet)) {
            $stylesheet = '<link rel="stylesheet" href="' . ($this->listOfStylesheets[$this->stylesheet] ?? $this->stylesheet) . '">';
        }
        $markup = preg_replace('/<link rel="stylesheet" href="(.*?)">/', $stylesheet, $markup);

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
     * Set title
     *
     * @param string $title Set document title, description and header
     * @return void
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Set stylesheet
     *
     * @param string $stylesheet Use keywords for one of the preselected stylesheets
     * (see $listOfStylesheets, eg. »skeleton«), an empty string to remove the
     * style tag or the URL to any other existing stylesheet (eg. »/styles.css«)
     * @return void
     */
    public function setStylesheet($stylesheet) {
        $this->stylesheet = $stylesheet;
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
