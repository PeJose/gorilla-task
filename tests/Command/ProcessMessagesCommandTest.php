<?php

declare(strict_types=1);

namespace Tests\Command;

use App\Command\ProcessMessagesCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ProcessMessagesCommandTest extends TestCase
{
  public function testExecute(): void
  {
    $command = new ProcessMessagesCommand();
    $tester = new CommandTester($command);

    $tester->execute(['input_file' => 'test.json']);

    $this->assertEquals(0, $tester->getStatusCode());
    $this->assertStringContainsString('Processing messages', $tester->getDisplay());
  }
}
