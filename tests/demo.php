<?php

require __DIR__ . '/../vendor/autoload.php';

$template = new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate();
echo $template->getMarkup();
