<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Entity\EntityType;
use App\Entity\BaseEntity;

enum ReportPriority: string
{
  case Critical = 'critical';
  case High = 'high';
  case Normal = 'normal';
}

enum ReportStatus: string
{
  case Deadline = 'deadline';
  case New = 'new';
}

class Report extends BaseEntity
{
  public function __construct(
    string $description,
    public readonly ReportPriority $priority,
    public readonly DateTimeImmutable $dateOfReport,
    public readonly ReportStatus $status,
    public readonly string $serviceNotes,
    public readonly string $contactNumber,
  ) {
    parent::__construct($description, EntityType::Report);
  }
}
