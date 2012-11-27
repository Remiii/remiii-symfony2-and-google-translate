<?php

use ApiTranslator\Translator\Translator;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Dumper;


class TranslatorTest extends \PHPUnit_Framework_TestCase
{
    public function testinstanceOfTranslator()
    {
        $lang = "fr";
        $input = __DIR__."/../Fixtures/datas/test.$lang.yml";
        $output = __DIR__."/../Fixtures/output/test.en.yml";
        $origin = __DIR__."/../Fixtures/datas/test.en.yml";
        $translator = new Translator($lang, $input, $output );
        $translator->setLang("en");
        $yaml = Yaml::parse($input);
        $dumper = new Dumper(); 
        
        $copy_yaml = Yaml::parse($origin);
        if ( is_array ( $yaml ) ) {
            $translator->readAndTranslate($yaml, '', $copy_yaml);
            file_put_contents( $output , $dumper->dump($copy_yaml, 2));
        }        
        $this->assertTrue($translator instanceof Translator);
        
    }

}
