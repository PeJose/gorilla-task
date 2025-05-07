<?php

namespace App\Service;

use Exception;
use Symfony\Component\Filesystem\Filesystem;

class FileWriter
{
  /**
   * @param array<mixed, mixed> $data
   */
  public function writeArrayToFile(string $filename, array $data): void
  {
    $fs = new Filesystem();

    $content = json_encode($data, JSON_UNESCAPED_UNICODE);
    if (!$content) {

      throw new Exception(message: "Data not serializable to json", code: 0);
    }

    $fs->dumpFile($filename, $content);
  }
}
