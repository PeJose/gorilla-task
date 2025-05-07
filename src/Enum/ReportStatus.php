<?php

namespace App\Enum;

enum ReportStatus: string
{
  case Deadline = 'deadline';
  case New = 'new';
}