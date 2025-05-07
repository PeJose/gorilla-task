<?php

namespace App\Enum;

enum EntityType: string
{
  case Report = 'report';
  case Review = 'review';
  case Unprocessed = 'unprocessed';
}
