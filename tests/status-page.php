<?php

require __DIR__ . '/../vendor/autoload.php';

$template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
$template->setStylesheet('skeleton');
$template->setContent('<h1>Status</h1><p>All Systems Operational</p>');
echo $template->getMarkup();
