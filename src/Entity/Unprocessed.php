<?php

namespace App\Entity;

use App\Enum\ReasonType;
use DateTimeImmutable;

final readonly class Unprocessed extends Message
{
  public function __construct(
    int $number,
    string $description,
    ?DateTimeImmutable $dueDate,
    ?string $phone,
    public ReasonType $reason,
  ) {
    parent::__construct($number, $description, $dueDate, $phone);
  }

  public function mapToMessage(): Message
  {
    return new Message(
      number: $this->number,
      description: $this->description,
      dueDate: $this->dueDate,
      phone: $this->phone
    );
  }
}
