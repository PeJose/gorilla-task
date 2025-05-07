<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\FileWriter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class FileWriterTest extends TestCase
{
  private string $testFilePath;

  protected function setUp(): void
  {
    $this->testFilePath = __DIR__ . '/test_filewriter.json';
  }

  protected function tearDown(): void
  {
    $fs = new Filesystem();
    if ($fs->exists($this->testFilePath)) {
      $fs->remove($this->testFilePath);
    }
  }

  public function testWriteArrayToFile(): void
  {
    $fileWriter = new FileWriter();
    $data = ['key' => 'value', 'number' => 123];

    $fileWriter->writeArrayToFile($this->testFilePath, $data);

    $this->assertFileExists($this->testFilePath);
    $content = file_get_contents($this->testFilePath);
    $this->assertJson($content);
    $this->assertEquals(json_encode($data, JSON_UNESCAPED_UNICODE), $content);
  }

  public function testWriteArrayToFileThrowsExceptionOnInvalidData(): void
  {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Data not serializable to json');

    $fileWriter = new FileWriter();
    $data = [
      'invalid' => fopen('php://memory', 'r'), // Non-serializable data
    ];

    $fileWriter->writeArrayToFile($this->testFilePath, $data);
  }
}
