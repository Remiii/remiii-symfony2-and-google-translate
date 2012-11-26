<?php

namespace ApiTranslator\Translator;


use Symfony\Component\Yaml\Dumper;

class Translator
{
    private $key ;

    private $output ;

    private $file_Translator;

    private $lang;

    public function __construct ($key , $translator, $output)
    {
        $this->key = $key ;
        $this->file_Translator = $translator;
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
                $this->placeTranslationInYaml($yamlArray, array($keys, $this->translate( $this->getLang(), $element )), $copy_yaml);
            }
            $keys = explode(".", $keys);
            array_pop($keys);
            $keys = implode(".", $keys);
        }
        //if($base) {
            //$dumper = new Dumper(); 
            //file_put_contents( $this->output , $dumper->dump($yamlArray, 2));

        //}

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

    private function placeTranslationInYaml($yamlArray, $translation, &$copy_yaml)
    {
        $tab = explode(".", $translation[0]);
        $place = '';
        foreach($tab as $element) :
            $place .= "['$element']";
        endforeach;
        $place = str_replace('[\'\']', '', $place);
        //print($place."\n");
        eval('$copy_yaml'.$place.' = \''.$translation[1].'\';');

        
    }
}
