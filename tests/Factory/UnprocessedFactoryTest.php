<?php

declare(strict_types=1);

namespace Tests\Factory;

use App\Entity\Message;
use App\Factory\UnprocessedFactory;
use PHPUnit\Framework\TestCase;

class UnprocessedFactoryTest extends TestCase
{
  public function testCreate(): void
  {
    $factory = new UnprocessedFactory();
    $data = new Message(1, "Test unprocessed");

    $unprocessed = $factory->createEntityFromMessage($data);

    $this->assertEquals($data->description, $unprocessed->description);
  }
}
