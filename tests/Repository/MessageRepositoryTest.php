<?php

declare(strict_types=1);

namespace Tests\Repository;

use App\Repository\MessageRepository;
use App\Entity\Message;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class MessageRepositoryTest extends TestCase
{
  private string $testFilePath;

  protected function setUp(): void
  {
    $this->testFilePath = __DIR__ . '/test_messages.json';
  }

  protected function tearDown(): void
  {
    $fs = new Filesystem();
    if ($fs->exists($this->testFilePath)) {
      $fs->remove($this->testFilePath);
    }
  }

  public function testLoadMessages(): void
  {
    $fs = new Filesystem();
    $messages = [
      [
        'number' => 1,
        'description' => 'Test message 1',
        'dueDate' => '2025-05-12T10:00:00+00:00',
        'phone' => '123456789'
      ],
      [
        'number' => 2,
        'description' => 'Test message 2',
        'dueDate' => '2025-05-13T10:00:00+00:00',
        'phone' => '987654321'
      ]
    ];

    $fs->dumpFile($this->testFilePath, json_encode($messages, JSON_UNESCAPED_UNICODE));

    $repository = new MessageRepository();
    $loadedMessages = $repository->loadMessages($this->testFilePath);

    $this->assertCount(2, $loadedMessages);

    $this->assertInstanceOf(Message::class, $loadedMessages[0]);
    $this->assertEquals(1, $loadedMessages[0]->number);
    $this->assertEquals('Test message 1', $loadedMessages[0]->description);
    $this->assertEquals('2025-05-12T10:00:00+00:00', $loadedMessages[0]->dueDate->format(DATE_ATOM));
    $this->assertEquals('123456789', $loadedMessages[0]->phone);

    $this->assertInstanceOf(Message::class, $loadedMessages[1]);
    $this->assertEquals(2, $loadedMessages[1]->number);
    $this->assertEquals('Test message 2', $loadedMessages[1]->description);
    $this->assertEquals('2025-05-13T10:00:00+00:00', $loadedMessages[1]->dueDate->format(DATE_ATOM));
    $this->assertEquals('987654321', $loadedMessages[1]->phone);
  }
}
