<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Entity\EntityType;

class BaseEntity
{
  public readonly DateTimeImmutable $createdAt;

  public function __construct(
    public readonly string $description,
    public readonly EntityType $type,
  ) {
    $this->createdAt = new DateTimeImmutable();
  }
}
