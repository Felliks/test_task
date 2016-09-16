Test work
====

##Installation
* Download and extract this project
* Edit configuration file `app/config/parameters.yml`
* Run this commands:
```
$ composer install
$ php bin/console doctrine:database:create
$ php bin/console doctrine:generate:entities AppBundle
$ php php bin/console doctrine:schema:update --force
$ php bin/console server:start
```
* Go to `http://127.0.0.1:8000` in your browser
* Configuration file allowed days and times is located in the path `src/AppBundle/Resources/config/parameters.yml`