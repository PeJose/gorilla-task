<?php

declare(strict_types=1);

namespace Tests\Factory;

use App\Entity\Message;
use App\Enum\ReviewStatus;
use App\Factory\ReviewFactory;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ReviewFactoryTest extends TestCase
{
  public function testCreate(): void
  {
    $factory = new ReviewFactory();
    $data = new Message(1, "Test review");

    $review = $factory->createEntityFromMessage($data);

    $this->assertEquals($data->description, $review->description);
  }

  public function testStatuses(): void
  {
    $factory = new ReviewFactory();
    $dataNew = new Message(1, "Test review");

    $reviewNew = $factory->createEntityFromMessage($dataNew);

    $this->assertEquals($reviewNew->description, $dataNew->description);
    $this->assertEquals($reviewNew->status, ReviewStatus::New);

    $factory = new ReviewFactory();
    $dataPlanned = new Message(2, "Test review", new DateTimeImmutable());

    $reviewPlanned = $factory->createEntityFromMessage($dataPlanned);

    $this->assertEquals($reviewPlanned->description, $dataPlanned->description);
    $this->assertEquals($reviewPlanned->status, ReviewStatus::Planned);
  }
}
