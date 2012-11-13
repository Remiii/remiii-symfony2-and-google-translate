<?php

require_once __DIR__.'/../app.php';

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
            ->setName('demo:greet')
            ->setDescription('Greet someone')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Who do you want to greet?'
            )
            ->addOption(
               'yell',
               null,
               InputOption::VALUE_NONE,
               'If set, the task will yell in uppercase letters'
            )
        ; 
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

$languages = array(
        "en", "de"            
) ;

$longopts  = array(
    "languages::",    // Valeur optionnelle
);
$shortopts = "";


$options = getopt($shortopts, $longopts);

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
    }

}
