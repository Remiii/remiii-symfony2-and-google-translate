<?php

namespace ApiTranslator\Translator;



class Translator
{
    private $key ;

    private $output ;

    private $file_Translator;

    public function __construct ($key , $translator)
    {
        $this->key = $key ;
        $this->file_Translator = $translator;
    }

    public function translate( $lang, $message )
    {
        return exec("$this->file_Translator $this->key:$lang $message" ) ;
    }
}
