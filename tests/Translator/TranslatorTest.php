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
        
        $copy_yaml =  Yaml::parse($origin) ;
        if ( is_array ( $copy_yaml ) ) {
            $translator->readAndTranslate( $yaml, '', $copy_yaml ) ;
            file_put_contents( $output , $dumper->dump( $copy_yaml, 2 ) ) ;
        } else {
            $copy_yaml = $yaml ;
            $test = $translator->eraseValues( $copy_yaml ) ;
            $translator->readAndTranslate( $yaml, '', $test ) ;
            file_put_contents( $output , $dumper->dump($test, 2 ) ) ;
        }    
        $this->assertTrue($translator instanceof Translator ) ;
        
    }

    public function testOutputIntegrity()
    {
        $output = __DIR__ . "/../Fixtures/output/test.en.yml" ;
        $yaml_output = Yaml::parse( $output ) ;
        $this->assertTrue( in_array ( 'title' , array_keys( $yaml_output ) ) ) ;
        $this->assertNotEquals( 5, count( array_keys( $yaml_output ) ) ) ;
        $this->assertEquals( 6, count( array_keys( $yaml_output ) ) ) ;
    }
    
}
