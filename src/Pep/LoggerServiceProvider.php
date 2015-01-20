<?php

namespace Pep\Logger;

use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider {

  protected $defer = false;

  public function boot() {
    $this->package('pep/logger', 'pep/logger', realpath(__DIR__ . '/..'));
  }

  public function register() {
    $this->app['logger'] = $this->app->share(function($app) {
      return new Logger;
    });
  }

  public function provides() {
    return ['logger'];
  }

}