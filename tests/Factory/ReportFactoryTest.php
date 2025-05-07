<?php

declare(strict_types=1);

namespace Tests\Factory;

use App\Entity\Message;
use App\Enum\ReportPriority;
use App\Enum\ReportStatus;
use App\Factory\ReportFactory;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ReportFactoryTest extends TestCase
{
  public function testCreate(): void
  {
    $factory = new ReportFactory();
    $data = new Message(1, "Test report");

    $report = $factory->createEntityFromMessage($data);

    $this->assertEquals($data->description, $report->description);
  }

  public function testStatuses(): void
  {
    $factory = new ReportFactory();
    $dataNew = new Message(1, "Test review");

    $reviewNEw = $factory->createEntityFromMessage($dataNew);

    $this->assertEquals($reviewNEw->description, $dataNew->description);
    $this->assertEquals($reviewNEw->status, ReportStatus::New);

    $factory = new ReportFactory();
    $dataPlanned = new Message(2, "Test review", new DateTimeImmutable());

    $reviewPlanned = $factory->createEntityFromMessage($dataPlanned);

    $this->assertEquals($reviewPlanned->description, $dataPlanned->description);
    $this->assertEquals($reviewPlanned->status, ReportStatus::Deadline);
  }

  public function testPriorities(): void
  {
    $factory = new ReportFactory();
    $dataCritical = new Message(1, "Test review: bardzo pilne");
    $reviewCritical = $factory->createEntityFromMessage($dataCritical);

    $this->assertEquals($reviewCritical->description, $dataCritical->description);
    $this->assertEquals($reviewCritical->priority, ReportPriority::Critical);

    $dataHigh = new Message(2, "Test review: pilne");
    $reviewHigh = $factory->createEntityFromMessage($dataHigh);

    $this->assertEquals($reviewHigh->description, $dataHigh->description);
    $this->assertEquals($reviewHigh->priority, ReportPriority::High);

    $dataNormal = new Message(3, "Test review");
    $reviewNormal = $factory->createEntityFromMessage($dataNormal);

    $this->assertEquals($reviewNormal->description, $dataNormal->description);
    $this->assertEquals($reviewNormal->priority, ReportPriority::Normal);
  }
}
