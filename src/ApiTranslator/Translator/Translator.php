<?php

namespace ApiTranslator\Translator;


use Symfony\Component\Yaml\Dumper;
use Google\Translate\GoogleTranslate;

class Translator
{
    private $fromLanguage ;

    private $input;

    private $output ;

    private $file_Translator;

    private $lang;

    public function __construct ($fromLanguage , $input, $output)
    {
        $this->fromLanguage = $fromLanguage ;
        $this->translator = new GoogleTranslate();
        $this->input = $input;
        $this->output = $output;
    }

    public function translate( $lang, $message )
    {
        return $this->translator->translate($this->fromLanguage, $lang, utf8_decode($message) )[0] ;
    }

    public function readAndTranslate($yamlArray, $keys = "", &$copy_yaml)
    {
        foreach( $yamlArray as $key =>$element) {
            $keys .= ".".$key;
            if( is_array( $element ) ) {
                $this->readAndTranslate( $element, $keys, $copy_yaml );
            } else {
                $this->placeTranslationInYaml($yamlArray, array($keys, $this->translate( $this->getLang(), utf8_encode($element) )), $copy_yaml);
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
        eval('$copy_yaml'.$place.' = ($copy_yaml'.$place.'==\'\') ?  \''.str_replace('\'','',$translation[1]).'\' : $copy_yaml'.$place.';');

        
    }

    static public function eraseValues($yamlArray)
    {
        foreach($yamlArray as $key => $val):
            if(is_array($val)) {
                $yamlArray[$key] = self::eraseValues($val);
            } else {
                $yamlArray[$key] = '';
            }
        endforeach;
        return $yamlArray;
    }
}
