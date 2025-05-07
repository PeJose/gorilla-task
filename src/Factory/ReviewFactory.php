<?php

namespace App\Factory;

use App\Entity\Message;
use App\Entity\Review;
use App\Enum\ReviewStatus;

final class ReviewFactory implements EntityFactoryInterface
{
  public static function createEntityFromMessage(Message $msg): Review
  {
    $report = new Review(
      description: $msg->description,
      dateOfReview: $msg->dueDate,
      weekInYear: self::getWeekInYear($msg),
      status: self::getStatus($msg),
      followingInstructions: '',
      contactEmail: ''
    );

    return $report;
  }

  private static function getWeekInYear(Message $msg): string
  {
    if (!$msg->dueDate) {
      return "";
    }

    return $msg->dueDate->format('W');
  }

  private static function getStatus(Message $msg): ReviewStatus
  {
    if (!$msg->dueDate) {
      return ReviewStatus::New;
    }
    return ReviewStatus::Planned;
  }
}
