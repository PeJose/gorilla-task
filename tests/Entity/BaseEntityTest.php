<?php

declare(strict_types=1);

namespace Tests\Entity;

use App\Entity\BaseEntity;
use App\Enum\EntityType;
use PHPUnit\Framework\TestCase;

class BaseEntityTest extends TestCase
{
  public function testBaseEntityInitialization(): void
  {
    $entity = new BaseEntity(
      description: 'Test description',
      type: EntityType::Report
    );

    $this->assertEquals('Test description', $entity->description);
    $this->assertEquals(EntityType::Report, $entity->type);
    $this->assertInstanceOf(\DateTimeImmutable::class, $entity->createdAt);
  }
}
