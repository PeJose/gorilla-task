<?php

namespace App\Factory;

use App\Entity\Message;

interface EntityFactoryInterface
{
  public static function createEntityFromMessage(Message $msg): object;
}
