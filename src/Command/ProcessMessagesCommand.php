<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
  name: 'app:process-messages',
  description: 'Processes messages to different enities .json files',
  hidden: false,
  aliases: ['app:pm']
)]
class ProcessMessagesCommand extends Command
{
  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $output->writeln("Processing messages");
    return Command::SUCCESS;
  }
}
