<?php

namespace Pixelbrackets\Html5MiniTemplate;

class Html5MiniTemplate
{
    /**
     * The HTML5 template
     *
     * @var string
     */
    protected $markup = '';

    /**
     * Stylesheet preselection
     *
     * @var array<string>
     */
    protected $listOfStylesheets = [
        'bootstrap' => 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@4.3/dist/css/bootstrap.min.css',
        'example' => '/assets/css/stylesheet.css?v=1',
        'milligram' => 'https://cdn.jsdelivr.net/gh/milligram/milligram@1.3/dist/milligram.min.css',
        'minicss' => 'https://cdn.jsdelivr.net/gh/Chalarangelo/mini.css@3.0/dist/mini-default.min.css',
        'mui' => 'https://cdn.jsdelivr.net/gh/muicss/mui@0.9/packages/cdn/css/mui.min.css',
        'picnic' => 'https://cdn.jsdelivr.net/gh/franciscop/picnic@6.4/releases/plugins.min.css',
        'skeleton' => 'https://cdn.jsdelivr.net/gh/dhg/Skeleton@2.0.4/css/skeleton.css',
    ];

    /**
     * The document title
     *
     * @var string
     */
    protected $title = '';

    /**
     * The linked stylesheet
     *
     * @var string
     */
    protected $stylesheet = 'example';

    /**
     * The stylesheet render type
     *
     * @var string
     */
    protected $stylesheetMode = self::STYLE_LINK;

    /**
     * Additional metadata in the document head
     *
     * @var string
     */
    protected $additionalMetadata = '';

    /**
     * The documents main content
     *
     * @var string
     */
    protected $content = '';

    const STYLE_LINK = 'link';
    const STYLE_INLINE = 'inline';

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
     * @return string
     */
    protected function parseMarkup()
    {
        $markup = $this->markup;

        // Title
        $title = $this->getTitle() ?: 'HTML5 Example Page';
        $markup = preg_replace('/HTML5 Example Page/', htmlspecialchars($title), $markup);

        // Stylesheet
        if ($this->stylesheetMode === self::STYLE_INLINE) {
            $styles = $this->getStylesheetContent();
            $stylesheet = ($styles) ? '<style>' . $styles . '</style>' : '';
        } else {
            $stylesheetUrl = $this->getStylesheetUrl();
            $stylesheet = ($stylesheetUrl) ? '<link rel="stylesheet" href="' . htmlspecialchars($stylesheetUrl) . '">' : '';
        }
        $markup = preg_replace('/<link rel="stylesheet" href="(.*?)">/', $stylesheet, $markup);

        // Additional Metadata
        $markup = preg_replace('/<\/head>/', $this->additionalMetadata . '</head>', $markup);

        // Content
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
    public function getMarkup()
    {
        return $this->parseMarkup();
    }

    /**
     * Set title
     *
     * @param string $title Set document title, description and header
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    protected function getTitle()
    {
        if (false === empty($this->title)) {
            return $this->title;
        }

        // Fallback: First headline in document
        preg_match('/(?s)(?<=<h1>)(.+?)(?=<\/h1>)/', $this->content, $headline);
        return $headline[0] ?? '';
    }

    /**
     * Set stylesheet
     *
     * @param string $stylesheet Use keywords for one of the preselected stylesheets
     * (see $listOfStylesheets, eg. »skeleton«), an empty string to remove the
     * style tag or the URL to any other existing stylesheet (eg. »/styles.css«)
     * @return void
     */
    public function setStylesheet($stylesheet)
    {
        $this->stylesheet = $stylesheet;
    }

    /**
     * Set stylesheet render mode.
     *
     * Html5MiniTemplate::STYLE_LINK: The given stylesheet URL is wrapped in a
     * LINK-tag.
     *
     * Html5MiniTemplate::STYLE_INLINE: The given stylesheet URL is fetched and
     * its content rendered inline in a STYLE-tag.
     *
     * @param string $mode Set render mode, either Html5MiniTemplate::STYLE_LINK or Html5MiniTemplate::STYLE_INLINE
     * @return void
     */
    public function setStylesheetMode($mode)
    {
        $this->stylesheetMode = $mode;
    }

    /**
     * Get stylesheet URL
     *
     * @return string
     */
    protected function getStylesheetUrl()
    {
        return $this->listOfStylesheets[$this->stylesheet] ?? $this->stylesheet;
    }

    /**
     * Get stylesheet content
     *
     * @return string
     */
    protected function getStylesheetContent()
    {
        $stylesheetUrl = $this->getStylesheetUrl();

        // try to get a cached version first
        $cachefile = sys_get_temp_dir(). '/' . md5($stylesheetUrl) . '.css';
        if (file_exists($cachefile) && (filemtime($cachefile) > (time() - 86400))) { // 1 day
            return file_get_contents($cachefile);
        }

        try {
            $stylesheetContent = file_get_contents($stylesheetUrl) ?: '';
            // try to cache the file
            file_put_contents($cachefile, $stylesheetContent, LOCK_EX);
        } catch (\Exception $e) {
            // Catch exception if resource is not reachable
            $stylesheetContent = '';
        }

        return $stylesheetContent;
    }

    /**
     * Set any additional metadata like metatags or link references.
     *
     * @param string $metadata Additional metadata for document head
     * @return void
     */
    public function setAdditionalMetadata($metadata)
    {
        $this->additionalMetadata = $metadata;
    }

    /**
     * Set markup for document body
     *
     * @param string $text Markup for document body
     * @return void
     */
    public function setContent($text)
    {
        $this->content = $text;
    }
}
