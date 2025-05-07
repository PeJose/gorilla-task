<?php

namespace App\Factory;

use App\Entity\Message;
use App\Entity\Unprocessed;
use App\Enum\ReasonType;

final class UnprocessedFactory implements EntityFactoryInterface
{
  public static function createEntityFromMessage(Message $msg, ?ReasonType $reason = null): Unprocessed
  {
    return new Unprocessed(
      number: $msg->number,
      description: $msg->description,
      dueDate: $msg->dueDate,
      phone: $msg->phone,
      reason: $reason ?? ReasonType::Duplicate
    );
  }
}
