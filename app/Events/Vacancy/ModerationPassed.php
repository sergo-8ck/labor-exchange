<?php

namespace App\Events\Advert;

use App\Entity\Vacancy;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ModerationPassed
{
  use Dispatchable, SerializesModels;

  public $advert;

  public function __construct(Vacancy $vacancy)
  {
    $this->advert = $vacancy;
  }
}
