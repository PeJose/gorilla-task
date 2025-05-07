<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\ConsoleLogger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleLoggerTest extends TestCase
{
  public function testLogStep(): void
  {
    $output = $this->createMock(OutputInterface::class);
    $output->expects($this->once())
      ->method('writeln')
      ->with($this->equalTo('<app_header>[App]</app_header>: Test message'));

    $logger = new ConsoleLogger($output);
    $logger->logStep('Test message');
  }

  public function testLogError(): void
  {
    $output = $this->createMock(OutputInterface::class);
    $output->expects($this->once())
      ->method('writeln')
      ->with($this->equalTo('<error_header>[Error]</error_header>: Error message'));

    $logger = new ConsoleLogger($output);
    $logger->logError('Error message');
  }
}
