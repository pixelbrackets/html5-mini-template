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
        'barebone' => 'https://cdn.jsdelivr.net/gh/pixelbrackets/barebone-stylesheet@1.2/dist/barebone.min.css',
        'bootstrap' => 'https://cdn.jsdelivr.net/gh/twbs/bootstrap@4.3/dist/css/bootstrap.min.css',
        'example' => '/assets/css/stylesheet.css?v=1',
        'gfm' => 'https://cdn.jsdelivr.net/gh/pixelbrackets/gfm-stylesheet@1.1/dist/gfm.min.css',
        'milligram' => 'https://cdn.jsdelivr.net/gh/milligram/milligram@1.3/dist/milligram.min.css',
        'minicss' => 'https://cdn.jsdelivr.net/gh/Chalarangelo/mini.css@3.0/dist/mini-default.min.css',
        'mui' => 'https://cdn.jsdelivr.net/gh/muicss/mui@0.9/packages/cdn/css/mui.min.css',
        'mvp' => 'https://cdn.jsdelivr.net/gh/andybrewer/mvp@1.12/mvp.css',
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
    protected $stylesheet = '';

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
     * @var string|null
     */
    protected $content;

    const STYLE_LINK = 'link';
    const STYLE_INLINE = 'inline';

    /**
     * Mini Template
     *
     * @return void
     */
    public function __construct()
    {
        $this->markup = $this->getFileContent(__DIR__ . '/../resources/template.html');
    }

    /**
     * Process all changes like custom content
     *
     * @return string
     */
    protected function parseMarkup()
    {
        $markup = $this->markup;
        $content = $this->content;

        // No message set = early return example template
        if ($content === null) {
            return self::getTemplate();
        }

        // Title
        $title = $this->getTitle() ?: 'Untitled Document';
        $markup = preg_replace('/<title>(.*?)<\/title>/', '<title>' . htmlspecialchars($title) . '</title>', $markup);

        // Reuse title in meta description
        $markup = preg_replace('/<meta name="description" content="(.*?)">/', '<meta name="description" content="' . htmlspecialchars($title) . '">', $markup);

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
        /** @var string $markup */
        $markup = preg_replace('/<body>(.*?)<\/body>/is', '<body>' . $content . '</body>', $markup);

        // That's it
        return $markup;
    }

    /**
     * Wrap file_get_contents function and throw errors if needed
     *
     * @param string $file File-URI to read its content from
     * @return string
     */
    protected function getFileContent(string $file): string
    {
        if (($content = file_get_contents($file)) === false) {
            throw new \RuntimeException('Can not access file to read its content');
        }
        return $content;
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
     * Get example template
     *
     * @return string
     */
    public static function getTemplate()
    {
        if (($content = file_get_contents(__DIR__ . '/../resources/template.html')) === false) {
            throw new \RuntimeException('Can not access file to read its content');
        }
        return $content;

    }

    /**
     * Set title
     *
     * @param string $title Set document title, description and header
     * @return Html5MiniTemplate
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
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
     * @return Html5MiniTemplate
     */
    public function setStylesheet($stylesheet)
    {
        $this->stylesheet = $stylesheet;
        return $this;
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
     * @return Html5MiniTemplate
     */
    public function setStylesheetMode($mode)
    {
        $this->stylesheetMode = $mode;
        return $this;
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
     * Get stylesheet content and cache it in filesystem
     *
     * @return string
     */
    protected function getStylesheetContent()
    {
        $stylesheetUrl = $this->getStylesheetUrl();

        // Try to get a cached version first
        $cachefile = sys_get_temp_dir() . '/' . md5($stylesheetUrl) . '.css';
        if (file_exists($cachefile) && (filemtime($cachefile) > (time() - 86400))) { // 1 day
            return $this->getFileContent($cachefile);
        }

        try {
            $stylesheetContent = $this->getFileContent($stylesheetUrl) ?: '';
            // Cache the file
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
     * @return Html5MiniTemplate
     */
    public function setAdditionalMetadata($metadata)
    {
        $this->additionalMetadata = $metadata;
        return $this;
    }

    /**
     * Set markup for document body
     *
     * @param string $text Markup for document body
     * @return Html5MiniTemplate
     */
    public function setContent($text)
    {
        $this->content = $text;
        return $this;
    }
}
