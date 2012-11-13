<?php

require_once __DIR__.'/../app.php';

use ApiTranslator\Translator\Translator;
use Symfony\Component\Yaml\Yaml;

$languages = array(
        "en", "de"            
) ;

$file_toTranslate = Yaml::parse(__DIR__."/../datas/messages.fr.yml") ;

$translator = new Translator("fr", __DIR__.'/../vendor/shvets/google-translate/bin/t' ) ;

foreach($languages as $lang) {
    $text = '';
    $resource = fopen(__DIR__."/../output/messages.$lang.yml", "w+");
    foreach($file_toTranslate as $key => $val) {
        $traduction = $translator->translate( $lang , $val ) ;
        $text .= "$key: $traduction\n" ;
    }
    fwrite($resource, $text);
    fclose($resource);
}
