<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Entity\EntityType;


enum ReviewStatus: string
{
  case Planned = 'planned';
  case New = 'new';
}

class Review extends BaseEntity
{
  public function __construct(
    string $description,
    public readonly DateTimeImmutable $dateOfReview,
    public readonly int $weekInYear,
    public readonly ReviewStatus $status,
    public readonly string $followingInstructions,
    public readonly string $contactEmail,
  ) {
    parent::__construct($description, EntityType::Review);
  }
}
