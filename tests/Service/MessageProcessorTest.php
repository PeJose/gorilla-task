<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Entity\Message;
use App\Entity\Review;
use App\Entity\Report;
use App\Entity\Unprocessed;
use App\Service\MessageProcessor;
use PHPUnit\Framework\TestCase;

class MessageProcessorTest extends TestCase
{
  public function testProcessMessagesWithUniqueDescriptions(): void
  {
    $processor = new MessageProcessor();
    $messages = [
      new Message(1, 'przegląd'),
      new Message(2, 'pilne'),
      new Message(3, 'ważne')
    ];

    $result = $processor->processMessages($messages);

    $this->assertCount(2, $result['reports']);
    $this->assertCount(1, $result['reviews']);
    $this->assertEmpty($result['unprocessed']);
  }

  public function testProcessMessagesWithDuplicates(): void
  {
    $processor = new MessageProcessor();
    $messages = [
      new Message(1, 'przegląd'),
      new Message(2, 'przegląd'),
      new Message(3, 'pilne')
    ];

    $result = $processor->processMessages($messages);

    $this->assertCount(1,  $result['reports']);
    $this->assertCount(1, $result['reviews']);
    $this->assertCount(1, $result['unprocessed']);
    $this->assertInstanceOf(Unprocessed::class, $result['unprocessed'][0]);
  }

  public function testProcessMessagesWithEmptyDescriptions(): void
  {
    $processor = new MessageProcessor();
    $messages = [
      new Message(1, ''),
      new Message(2, 'pilne'),
      new Message(3, '')
    ];

    $result = $processor->processMessages($messages);

    $this->assertCount(0, $result['reviews']);
    $this->assertCount(1, $result['reports']);
    $this->assertCount(2, $result['unprocessed']);
    $this->assertInstanceOf(Unprocessed::class, $result['unprocessed'][0]);
  }

  public function testProcessedResultStructure(): void
  {
    $processor = new MessageProcessor();
    $messages = [
      new Message(1, 'przegląd'),
      new Message(2, 'pilne')
    ];

    $result = $processor->processMessages($messages);

    $this->assertArrayHasKey('reviews', $result);
    $this->assertArrayHasKey('reports', $result);
    $this->assertArrayHasKey('unprocessed', $result);
  }
}
