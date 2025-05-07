<?php

namespace App\Service;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class LoggerFactory
{
  private static ?Logger $logger = null;

  public static function GetLogger(): Logger
  {
    if (self::$logger === null) {
      self::$logger = new Logger('app');
      self::$logger->pushHandler(new StreamHandler(__DIR__ . "../../var/log/app.log", Level::Debug));
    }
    return self::$logger;
  }
}
