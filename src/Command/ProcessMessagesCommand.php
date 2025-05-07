<?php

namespace App\Command;

use App\Enum\EntityType;
use App\Repository\MessageRepository;
use App\Service\FileWriter;
use App\Service\MessageProcessor;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Review;
use App\Entity\Report;
use App\Service\ConsoleLogger;
use Exception;

/**
 * @phpstan-import-type ProcessedResult from MessageProcessor
 * @phpstan-type OutputFileNames array{reports: string, reviews: string, unprocessed: string}
 */

#[AsCommand(
  name: 'app:process-messages',
  description: 'Processes messages to different enities .json files',
  hidden: false,
  aliases: ['app:pm']
)]
class ProcessMessagesCommand extends Command
{
  /** @var OutputFileNames  */
  private array $outputFiles = [
    'reports' => 'var/output/reports.json',
    'reviews' => 'var/output/reviews.json',
    'unprocessed' => 'var/output/unprocessed.json',
  ];

  protected function configure()
  {
    $this->addArgument('input_file', InputArgument::REQUIRED, 'File containing entry messages.');
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $consoleLogger = new ConsoleLogger($output);

    try {
      $consoleLogger->logStep("Starting message processor.");

      $fileName = $input->getArgument('input_file');

      if (!is_string($fileName)) {
        throw new Exception(message: "The input file name must be a string.", code: 1);
      }

      $consoleLogger->logStep('Loading messages from entry file: ' . $fileName);
      $loader = new MessageRepository();
      $messagesArray = $loader->loadMessages("./$fileName");

      $consoleLogger->logStep("Processing messages");
      $processor = new MessageProcessor();
      $result = $processor->processMessages($messagesArray);

      $fileWriter = new FileWriter();

      $consoleLogger->logStep("Writing reports to {$this->outputFiles['reports']}");
      $fileWriter->writeArrayToFile($this->outputFiles['reports'], $result['reports']);

      $consoleLogger->logStep("Writing reviews to {$this->outputFiles['reviews']}");
      $fileWriter->writeArrayToFile($this->outputFiles['reviews'], $result['reviews']);

      $consoleLogger->logStep("Writing unprocessed to {$this->outputFiles['unprocessed']}");
      $fileWriter->writeArrayToFile($this->outputFiles['unprocessed'], array_map(fn($msg) => $msg->mapToMessage(), $result['unprocessed']));

      $consoleLogger->logResults($result, $this->outputFiles);
    } catch (Exception $e) {
      $consoleLogger->logError($e->getMessage());
      return Command::FAILURE;
    }
    return Command::SUCCESS;
  }
}
