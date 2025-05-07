<?php

declare(strict_types=1);

namespace Tests\Entity;

use App\Entity\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
  public function testMessageInitialization(): void
  {
    $message = new Message(
      number: 1,
      description: 'Test message',
      dueDate: new \DateTimeImmutable('2025-05-12'),
      phone: '123456789'
    );

    $this->assertEquals(1, $message->number);
    $this->assertEquals('Test message', $message->description);
    $this->assertEquals('2025-05-12', $message->dueDate->format('Y-m-d'));
    $this->assertEquals('123456789', $message->phone);
  }
}
