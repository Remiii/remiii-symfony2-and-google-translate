<?php

namespace ApiTranslator\Translator;


use Symfony\Component\Yaml\Dumper;

class Translator
{
    private $key ;

    private $input;

    private $output ;

    private $file_Translator;

    private $lang;

    public function __construct ($key , $input, $output)
    {
        $this->key = $key ;
        $this->file_Translator = __DIR__.'/../../../vendor/remiii/google-translate/bin/t';
        $this->input = $input;
        $this->output = $output;
    }

    public function translate( $lang, $message )
    {
        return exec("$this->file_Translator $this->key:$lang ".utf8_decode($message) ) ;
    }

    public function readAndTranslate($yamlArray, $keys = "", &$copy_yaml)
    {
        foreach( $yamlArray as $key =>$element) {
            $keys .= ".".$key;
            if( is_array( $element ) ) {
                $this->readAndTranslate( $element, $keys, $copy_yaml );
            } else {
                $this->placeTranslationInYaml($yamlArray, array($keys, $this->translate( $this->getLang(), utf8_encode($element) )), &$copy_yaml);
            }
            $keys = explode(".", $keys);
            array_pop($keys);
            $keys = implode(".", $keys);
        }

    }



    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function setTranslator($translator)
    {
        $this->file_Translator = $translator;    
        return $this;
    }

    public function getTranslator()
    {
        return $this->file_Translator;
    }


    private function placeTranslationInYaml($yamlArray, $translation, &$copy_yaml)
    {
        $tab = explode(".", $translation[0]);
        $place = '';
        foreach($tab as $element) :
            $place .= "['$element']";
        endforeach;
        $place = str_replace('[\'\']', '', $place);
        //print($place."\n");
        eval('$copy_yaml'.$place.' = ($copy_yaml'.$place.'==\'\') ?  \''.str_replace('\'','',$translation[1]).'\' : $copy_yaml'.$place.';');

        
    }
}
