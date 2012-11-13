<?php

require_once 'vendor/symfony/class-loader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(
    array(  
        "Symfony"=> __DIR__."/vendor/symfony/symfony/src",
        "ApiTranslator" => __DIR__."/src"
    )
);

$loader->register();
