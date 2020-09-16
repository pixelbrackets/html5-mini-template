<?php

require __DIR__ . '/../vendor/autoload.php';

echo \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate::getTemplate();

// same as
//   echo (new \Pixelbrackets\Html5MiniTemplate\Html5MiniTemplate())->getMarkup();
