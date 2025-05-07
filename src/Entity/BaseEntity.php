<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Enum\EntityType;

readonly class BaseEntity
{
  public DateTimeImmutable $createdAt;

  public function __construct(
    public string $description,
    public EntityType $type,
  ) {
    $this->createdAt = new DateTimeImmutable();
  }

  public static function isValid(Message $msg): bool
  {
    return true;
  }
}
