<?php

use ApiTranslator\Translator\Translator;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Dumper;


class TranslatorTest extends \PHPUnit_Framework_TestCase
{
    public function testinstanceOfTranslator()
    {
        $lang = "fr";
        $output = __DIR__."/../Fixtures/datas/test.$lang.yml";
        $translator = new Translator($lang, __DIR__.'/../../vendor/remiii/google-translate/bin/t', $output );
        $translator->setLang("en");
        $yaml = Yaml::parse($output);
        $dumper = new Dumper(); 
        
        if ( is_array ( $yaml ) ) {
            $copy_yaml = $yaml;
            $translator->readAndTranslate($yaml, '', $copy_yaml);
            print_r($copy_yaml);
        } else {
        }
        //$resource = fopen(__DIR__."/../../output/messages.$lang.yml", "w+");
                //foreach($file_toTranslate as $key => $val) {
                    //foreach($val as $string_toTranslate) {
                        //$traduction = $translator->translate( $lang , utf8_encode($string_toTranslate) ) ;
                        //$text .= "$key: $traduction\n" ;
                    //}
                //}
        
        $this->assertTrue($translator instanceof Translator);
        
    }

}
