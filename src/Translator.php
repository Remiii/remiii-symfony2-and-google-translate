<?php
require_once __DIR__."/../app.php";


use Symfony\Component\Yaml\Yaml;

$array = Yaml::parse($file);

print Yaml::dump($array);
