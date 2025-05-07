<?php

namespace App\Factory;

use App\Entity\Message;
use App\Entity\Report;
use App\Enum\ReportPriority;
use App\Enum\ReportStatus;

final class ReportFactory implements EntityFactoryInterface
{
  public static function createEntityFromMessage(Message $msg): Report
  {
    $report = new Report(
      description: $msg->description,
      priority: self::getPriority(($msg)),
      dateOfReport: $msg->dueDate,
      status: self::getStatus($msg),
      serviceNotes: '',
      contactNumber: $msg->phone ?? ''
    );

    return $report;
  }

  private static function getPriority(Message $msg): ReportPriority
  {
    $desc = mb_strtolower($msg->description);
    if (
      str_contains(haystack: $desc, needle: 'bardzo pilne')
      || str_contains(haystack: $desc, needle: 'bardzo pilna')
    ) {
      return ReportPriority::Critical;
    } else if (
      str_contains(haystack: $desc, needle: 'pilne')
      || str_contains(haystack: $desc, needle: 'pilna')
    ) {
      return ReportPriority::High;
    }
    return ReportPriority::Normal;
  }

  private static function getStatus(Message $msg): ReportStatus
  {
    if ($msg->dueDate) {
      return ReportStatus::Deadline;
    }
    return ReportStatus::New;
  }
}
