<?php

namespace App\Entity;

use DateTimeImmutable;

readonly class Message
{
  public function __construct(
    public int $number,
    public string $description,
    public ?DateTimeImmutable $dueDate = null,
    public ?string $phone = null
  ) {}
}
