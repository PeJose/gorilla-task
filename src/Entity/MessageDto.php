<?php

namespace App\Entity;

final class MessageDto
{
  public function __construct(
    public int $number,
    public string $description,
    public string $dueDate,
    public string $phone
  ) {}
}
