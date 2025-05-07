<?php

namespace App\Service;

use App\Enum\EntityType;
use App\Entity\Message;
use App\Entity\Unprocessed;
use App\Entity\Report;
use App\Entity\Review;
use App\Enum\ReasonType;
use App\Factory\ReportFactory;
use App\Factory\ReviewFactory;
use App\Factory\UnprocessedFactory;

/** @phpstan-type ProcessedResult array{
 *   reviews: array<int, Review>,
 *   reports: array<int, Report>,
 *   unprocessed: array<int, Unprocessed>
 * }
 */

final class MessageProcessor
{
  /**
   * @param array<int, Message> $msgArray
   * @return ProcessedResult
   */
  public function processMessages(array $msgArray): array
  {
    $uniqueMsgs = $this->deduplicate($msgArray);

    $reports = [];
    $reviews = [];

    foreach ($uniqueMsgs['unique'] as $msg) {
      $entity = $this->decideAndCreateEntity($msg);
      switch ($entity->type) {
        case EntityType::Report: {
            if ($entity instanceof Report) {
              $reports[] = $entity;
            }
            break;
          }
        case EntityType::Review: {
            if ($entity instanceof Review) {
              $reviews[] = $entity;
            }
            break;
          }
      }
    }

    return [
      'reports' => $reports,
      'reviews' => $reviews,
      'unprocessed' => $uniqueMsgs['unprocessed']
    ];
  }

  private function decideAndCreateEntity(Message $msg): Review|Report
  {
    if (stripos($msg->description, 'przegląd') !== false) {
      return ReviewFactory::createEntityFromMessage($msg);
    }
    return ReportFactory::createEntityFromMessage($msg);
  }

  /**
   * @param array<int, Message> $msgArray
   * @return array{
   *    unique: array<int, Message>,
   *    unprocessed: array<int, Unprocessed>
   * }
   */
  private function deduplicate(array $msgArray): array
  {
    $seen = [];
    $unique = [];
    $unprocessed = [];

    foreach ($msgArray as $msg) {
      if (!$msg->description) {
        $unprocessedMsg = UnprocessedFactory::createEntityFromMessage($msg, ReasonType::Empty);
        $unprocessed[] = $unprocessedMsg;
        continue;
      }
      if (!in_array(needle: $msg->description, haystack: $seen)) {
        $seen[] = $msg->description;
        $unique[] = $msg;
      } else {
        $unprocessedMsg = UnprocessedFactory::createEntityFromMessage($msg, ReasonType::Duplicate);
        $unprocessed[] = $unprocessedMsg;
      }
    }
    return [
      'unique' =>  $unique,
      'unprocessed' => $unprocessed,
    ];
  }
}
