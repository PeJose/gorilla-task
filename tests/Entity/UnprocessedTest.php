<?php

declare(strict_types=1);

namespace Tests\Entity;

use App\Entity\Unprocessed;
use App\Enum\ReasonType;
use PHPUnit\Framework\TestCase;

class UnprocessedTest extends TestCase
{
  public function testUnprocessedInitialization(): void
  {
    $unprocessed = new Unprocessed(
      number: 1,
      description: 'Test unprocessed',
      dueDate: new \DateTimeImmutable('2025-05-12'),
      phone: '123456789',
      reason: ReasonType::Duplicate
    );

    $this->assertEquals(1, $unprocessed->number);
    $this->assertEquals('Test unprocessed', $unprocessed->description);
    $this->assertEquals('2025-05-12', $unprocessed->dueDate->format('Y-m-d'));
    $this->assertEquals('123456789', $unprocessed->phone);
    $this->assertEquals(ReasonType::Duplicate, $unprocessed->reason);
  }

  public function testMapToMessage(): void
  {
    $unprocessed = new Unprocessed(
      number: 1,
      description: 'Test unprocessed',
      dueDate: new \DateTimeImmutable('2025-05-12'),
      phone: '123456789',
      reason: ReasonType::Duplicate
    );

    $message = $unprocessed->mapToMessage();

    $this->assertEquals(1, $message->number);
    $this->assertEquals('Test unprocessed', $message->description);
    $this->assertEquals('2025-05-12', $message->dueDate->format('Y-m-d'));
    $this->assertEquals('123456789', $message->phone);
  }
}
