<?php

namespace Pep\Logger;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Str;
use Config;

class Logger {

  public static $loggers = [];

  public static function create($name = '', $level = MonologLogger::WARNING) {
    $logger = new MonologLogger($name);

    $logger->addStreamHandler(Config::get('logger::path'), $level);
    self::$loggers[$level] = $logger;

    return $logger;
  }

  public static function __callStatic($name, $arguments) {
    $fn = Str::camel("add_$name");
    $level = Str::upper($name);
    $levelCode = MonologLogger::$level;

    if (array_key_exists($levelCode, self::$loggers)) {
      $logger = self::$loggers[$levelCode];
    } else {
      $logger = self::create($level, $levelCode);
    }

    $logger->$fn($arguments[0], $arguments[1]);
  }

}