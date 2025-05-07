<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Enum\EntityType;
use App\Entity\BaseEntity;
use App\Enum\ReportPriority;
use App\Enum\ReportStatus;

final readonly class Report extends BaseEntity
{
  public function __construct(
    string $description,
    public ReportPriority $priority,
    public ?DateTimeImmutable $dateOfReport,
    public ReportStatus $status,
    public string $serviceNotes,
    public string $contactNumber,
  ) {
    parent::__construct($description, EntityType::Report);
  }

  public static function isValid(Message $msg): bool
  {
    return str_contains(haystack: $msg->description, needle: "przelew");
  }
}
