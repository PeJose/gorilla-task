<?php

namespace App\Enum;

enum ReasonType: string
{
  case Empty = 'empty';
  case Duplicate = 'duplicate';

  public function toReadableFormat(): string
  {
    return match ($this) {
      ReasonType::Duplicate => 'Duplicated message description',
      ReasonType::Empty => 'Empty message description'
    };
  }
}
