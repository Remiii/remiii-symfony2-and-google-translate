<?php

namespace ApiTranslator;
use ApiTranslator\Translator\Translator;

use Symfony\Component\Yaml\Yaml;

use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Finder\Finder;

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
                'base_language',
                InputArgument::REQUIRED,
                'the base language used for translation'
                )
            ->addArgument(
                'languages',
                InputArgument::REQUIRED,
                "languages that you want translate your yml in. \n Ex : \"es, fr, it\""
                )
        ; 
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $languages=  explode( "," , $input->getArgument('languages') ) ;
        
        $finder = new Finder() ;
        $finder->files()->in(__DIR__."/../../datas/") ;


        
        $output_path = __DIR__."/../../output/";
        $datas_path   = __DIR__."/../../datas/";

        $key = $input->getArgument('base_language');
        $input = $datas_path."messages.$key.yml";
        foreach ( $languages as $lang ) {
            $lang = trim($lang); 
            $output = $output_path."messages.$lang.yml";
            $origin = $datas_path."messages.$lang.yml";
            $translator = new Translator($key, $input, $output );
            $translator->setLang($lang);
            $yaml = Yaml::parse($input);
            $dumper = new Dumper(); 
        
            $copy_yaml =  Yaml::parse($origin) ;
            if ( is_array ( $copy_yaml ) ) {
                $translator->readAndTranslate( $yaml, '', $copy_yaml ) ;
                file_put_contents( $output , $dumper->dump( $copy_yaml, 2 ) ) ;
            } else {
                $copy_yaml = $yaml ;
                $test = Translator::eraseValues( $copy_yaml ) ;
                $translator->readAndTranslate( $yaml, '', $test ) ;
                file_put_contents( $output , $dumper->dump($test, 2 ) ) ;
            }
        }
    }


}
