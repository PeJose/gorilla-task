<?php

declare(strict_types=1);

namespace Tests\Factory;

use App\Factory\EntityFactoryInterface;
use PHPUnit\Framework\TestCase;

class EntityFactoryInterfaceTest extends TestCase
{
  public function testInterfaceExists(): void
  {
    $this->assertTrue(interface_exists(EntityFactoryInterface::class));
  }
}
