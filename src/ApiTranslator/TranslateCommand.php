<?php

namespace ApiTranslator;
use ApiTranslator\Translator\Translator;
use Symfony\Component\Yaml\Yaml;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TranslateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('translator')
            ->setDescription('Translator command using google API')
            ->addArgument(
                'languages',
                InputArgument::REQUIRED,
                'languages that you want translate your yml in.'
                )
        ; 
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $languages=  explode( "," , $input->getArgument('languages') );
        
        $file_toTranslate = Yaml::parse(__DIR__."/../../datas/messages.fr.yml") ;

        $translator = new Translator("fr", __DIR__.'/../../vendor/shvets/google-translate/bin/t' ) ;

        foreach($languages as $lang) {
            $lang = trim($lang);
            $text = '';
            $resource = fopen(__DIR__."/../../output/messages.$lang.yml", "w+");
            foreach($file_toTranslate as $key => $val) {
                $traduction = $translator->translate( $lang , $val ) ;
                $text .= "$key: $traduction\n" ;
            }
            fwrite($resource, $text);
            fclose($resource);
            }
        }

}
