# symfony2-and-google-translate

App creating your sf2 translations files via google translate API.<br />

## Requirements

* Ruby
* RubyGems

## How to use

Get Composer.

Get vendors:
```bash
$ php composer.phar install
```

Install gem ruby google-translate:
```bash
$ cd vendor/remiii/google-translate
$ gem install google-translate
```

Put your base messages.[yourlanguage].yml file in datas directory.<br/>

Run the program with that command:
```bash
$ php app/console translator "[yourlanguage]" "es, en, it"
```
This command translates your base yml file in spanish, english and italian. File will be created in output directory.<br />That's it !

