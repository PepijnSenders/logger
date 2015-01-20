Logger ![Build status](https://api.travis-ci.org/PepijnSenders/logger.png)
------

Laravel multilogger component, to make logging to different files easy.

Installation:

    composer require pep/logger;
    php artisan config:publish pep/logger;

Afterwards add a path to where you want your different logfiles in the package config.

Usage:

    Logger::warning('{file-namespace}', '{message}', [{context}]);

The following functions are available:

    ::debug
    ::info
    ::warning
    ::error
    ::critical
    ::alert
    ::emergency
