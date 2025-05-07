<?php

namespace App\Enum;

enum ReportPriority: string
{
  case Critical = 'critical';
  case High = 'high';
  case Normal = 'normal';
}
