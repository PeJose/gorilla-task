<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Enum\EntityType;
use App\Enum\ReviewStatus;

final readonly class Review extends BaseEntity
{
  public function __construct(
    string $description,
    public ?DateTimeImmutable $dateOfReview,
    public string $weekInYear,
    public ReviewStatus $status,
    public string $followingInstructions,
    public string $contactEmail,
  ) {
    parent::__construct($description, EntityType::Review);
  }
}
