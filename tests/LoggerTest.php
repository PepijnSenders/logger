<?php

use Pep\Logger\Logger;
use Illuminate\Support\Facades\Config;
use Mockery\Mockery;

class LoggerTest extends PHPUnit_Framework_TestCase {

  public function testLog() {
    $functions = [
      'debug',
      'info',
      'warning',
      'error',
      'critical',
      'alert',
      'emergency',
    ];

    foreach ($functions as $function) {
      $fileDir = __DIR__ . '/../tmp';
      $fileName = uniqid('file-');
      $value = uniqid('test-');
      Config::shouldReceive('get')->once()->andReturn($fileDir);

      Logger::{$function}($fileName, $value, []);

      $contents = file_get_contents("$fileDir/$fileName.log");

      $this->assertRegExp("/$value/", $contents);
    }
  }

}