<?php

require __DIR__ . '/../vendor/autoload.php';

$template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
$template->setTitle('Index');
$template->setStylesheet('skeleton');
$template->setStylesheetMode(\Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate::STYLE_INLINE);
$template->setAdditionalMetadata('<link rel="canonical" href="https://example.com/subpage/">');
$list = '';
foreach (['Air', 'Earth', 'Fire', 'Water'] as $element) {
    $list .= '<li>' . $element . '</li>';
}
$template->setContent('<h1>TOC</h1><ul>' . $list . '</ul>');
echo $template->getMarkup();
