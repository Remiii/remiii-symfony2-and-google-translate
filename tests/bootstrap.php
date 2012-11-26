<?php

$file = __DIR__.'/../vendor/autoload.php';
if (!file_exists($file)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}

$autoload = require_once $file;

if (class_exists('Doctrine\Common\Annotations\AnnotationRegistry')) {
    \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
}
