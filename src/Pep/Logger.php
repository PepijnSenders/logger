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

    $logger->pushHandler(new StreamHandler(Config::get('pep/logger::path') . "/$name.log", $level));
    self::$loggers[$level] = $logger;

    return $logger;
  }

  public static function __callStatic($name, $arguments) {
    $fn = Str::camel("add_$name");
    $level = Str::upper($name);
    $levelCode = constant("Monolog\Logger::$level");

    if (isset($arguments[0])) {
      $namespace = $arguments[0];
    } else {
      throw new LoggerException('Please provide a namespace.');
    }

    if (array_key_exists($namespace, self::$loggers)) {
      $logger = self::$loggers[$namespace];
    } else {
      $logger = self::create($namespace, $levelCode);
      self::$loggers[$namespace] = $logger;
    }

    if (isset($arguments[1])) {
      $message = $arguments[1];
    } else {
      throw new LoggerException('Please provide a message.');
    }

    if (isset($arguments[2])) {
      $context = $arguments[2];
    } else {
      $context = [];
    }

    $logger->$fn($message, $context);
  }

}