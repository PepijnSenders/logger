<?php

namespace Pep\Logger;

use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider {

  public function boot() {
    $this->package('pep/logger', 'logger', realpath(__DIR__));
  }

  public function register() {
    $this->app['logger'] = $this->app->share(function($app) {
      return new Logger;
    });
  }

}