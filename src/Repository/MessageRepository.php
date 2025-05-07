<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\MessageDto;
use DateTimeImmutable;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

final class MessageRepository
{
  /**
   * @return array<int, Message>
   */
  public function loadMessages(string $filePath): array
  {
    $fileSystem = new Filesystem();

    $fileString = $fileSystem->readFile($filePath);

    if (!json_validate($fileString)) {
      throw new Exception(message: "File doesn't have valid JSON syntax", code: 1);
    }

    /** @var ?array<int, MessageDto> $decoded */
    $decoded = json_decode($fileString);

    if (!is_array($decoded)) {
      throw new Exception(message: "Decoded JSON is not an array", code: 1);
    }

    return $this->mapMessages($decoded);
  }

  /**
   * @param array<int, MessageDto> $decoded
   * @return array<int, Message>
   */
  private function mapMessages(array $decoded): array
  {
    $messages = array_map(function ($item) {
      return new Message(
        number: $item->number,
        description: $item->description,
        dueDate: $item->dueDate ? new DateTimeImmutable($item->dueDate) : null,
        phone: $item->phone ?? null
      );
    }, $decoded);

    return $messages;
  }
}
