<?php

declare(strict_types=1);

namespace Tests\Entity;

use App\Entity\MessageDto;
use PHPUnit\Framework\TestCase;

class MessageDtoTest extends TestCase
{
  public function testConstructor(): void
  {
    $dto = new MessageDto(number: 1, description: "Test DTO", dueDate:"", phone: "1234");

    $this->assertEquals(1, $dto->number);
    $this->assertEquals('Test DTO', $dto->description);
  }
}
