<?php

declare(strict_types=1);

namespace Tests\Entity;

use App\Entity\Report;
use App\Enum\EntityType;
use App\Enum\ReportPriority;
use App\Enum\ReportStatus;
use PHPUnit\Framework\TestCase;

class ReportTest extends TestCase
{
  public function testReportInitialization(): void
  {
    $report = new Report(
      description: 'Test report',
      priority: ReportPriority::High,
      dateOfReport: new \DateTimeImmutable('2025-05-12'),
      status: ReportStatus::New,
      serviceNotes: 'Test notes',
      contactNumber: '123456789'
    );

    $this->assertEquals('Test report', $report->description);
    $this->assertEquals(ReportPriority::High, $report->priority);
    $this->assertEquals('2025-05-12', $report->dateOfReport->format('Y-m-d'));
    $this->assertEquals(ReportStatus::New, $report->status);
    $this->assertEquals('Test notes', $report->serviceNotes);
    $this->assertEquals('123456789', $report->contactNumber);
  }
}
