<?php

require_once  __DIR__.'/../vendor/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';


use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(
    array(  
        "Symfony\\ClassLoader"=> __DIR__."/../vendor/symfony/class-loader/",
        "Symfony\\Finder" => __DIR__."/../vendor/symfony/finder/",
        "Symfony\\Console" => __DIR__."/../vendor/symfony/console/",
        "Symfony\\Yaml" => __DIR__."/../vendor/symfony/yaml/",
        "ApiTranslator" => __DIR__."/../src"
    )
);

$loader->register();
