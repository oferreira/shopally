Get started
===================

Make sure brew is up to date:
    
    brew update
    brew upgrade

Install PHP 7.1
   
    brew tap homebrew/dupes
    brew tap homebrew/versions
    brew tap homebrew/homebrew-php
    
    brew unlink php70
    brew install php71

Install packages

    php composer.phar install --no-dev

RUN TESTS
-------------------

    php phpunit
