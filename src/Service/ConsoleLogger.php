<?php

namespace App\Service;

use Symfony\Component\Console\Output\OutputInterface;
use App\Command\ProcessMessagesCommand;
use App\Entity\Review;
use App\Entity\Report;
use App\Entity\Unprocessed;
use App\Enum\EntityType;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

/**
 * @phpstan-import-type ProcessedResult from MessageProcessor
 * @phpstan-import-type OutputFileNames from ProcessMessagesCommand
 * @phpstan-type EntityTypeUnion Report|Review|Unprocessed
 */
final class ConsoleLogger
{
  public function __construct(
    private OutputInterface $output
  ) {
    $this->configureStyles();
  }

  public function logStep(string $step): void
  {
    $this->output->writeln("<app_header>[App]</app_header>: {$step}");
  }

  public function logError(string $error): void
  {
    $this->output->writeln("<error_header>[Error]</error_header>: {$error}");
  }

  /**
   * @param ProcessedResult $result
   * @param OutputFileNames $outputFiles
   */
  public function logResults(array $result, array $outputFiles): void
  {
    $this->logStep("Printing reults:");
    $this->printSection(EntityType::Report->value, $result['reports'], $outputFiles['reports'], 'info');
    $this->printSection(EntityType::Review->value, $result['reviews'], $outputFiles['reviews'], 'info');

    $this->printSection(EntityType::Unprocessed->value, $result['unprocessed'], $outputFiles['unprocessed'], 'info');
    $this->output->writeln("\n<warning>These are the messages that couldn't be processed:</warning>");
    $table = new Table($this->output);
    $unprocessedMapped = array_map(
      fn($msg) => [
        $msg->number,
        $msg->reason->toReadableFormat()
      ],
      $result['unprocessed']
    );
    $table->setHeaders(['Message Number', 'Reason'])->setRows($unprocessedMapped);
    $table->render();

    $this->output->writeln('');
  }

  /**
   * @param string $label
   * @param array<int, EntityTypeUnion> $items
   * @param string $filename
   * @param string $styleTag
   */
  private function printSection(string $label, array $items, string $filename, string $styleTag): void
  {
    $this->printSectionTitle($label, $items);
    $this->printSectionFilename($filename);
  }

  /**
   * @param string $label
   * @param array<int, EntityTypeUnion> $items
   */
  private function printSectionTitle(string $label, array $items): void
  {
    $labelUppercase = mb_strtoupper($label);
    $count = count($items);
    $this->output->writeln('');
    $this->output->writeln("<section>=== Entity type: {$labelUppercase} ({$count}) ===</section>");
  }

  private function printSectionFilename(string $filename): void
  {
    $this->output->writeln("<file>Saved to: ./$filename</file>");
  }

  private function configureStyles(): void
  {
    $formatter = $this->output->getFormatter();

    if (!$formatter->hasStyle('section')) {
      $formatter->setStyle('section', new OutputFormatterStyle('white', null, ['bold']));
    }
    if (!$formatter->hasStyle('file')) {
      $formatter->setStyle('file', new OutputFormatterStyle('blue'));
    }
    if (!$formatter->hasStyle('warning')) {
      $formatter->setStyle('warning', new OutputFormatterStyle('black', 'yellow'));
    }
    if (!$formatter->hasStyle('app_header')) {
      $formatter->setStyle('app_header', new OutputFormatterStyle('green'));
    }
    if (!$formatter->hasStyle('error_header')) {
      $formatter->setStyle('error_header', new OutputFormatterStyle('white', 'red'));
    }
  }
}
