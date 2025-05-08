<?php

namespace App\Entity;

enum EntityType: string
{
  case Report = 'report';
  case Review = 'review';
}
