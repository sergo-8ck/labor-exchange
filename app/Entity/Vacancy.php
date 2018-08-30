<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string $status
 */
class Vacancy extends Model
{
  public const STATUS_MODERATION = 'moderation';
  public const STATUS_ACTIVE = 'active';

  protected $table = 'advert_adverts';
}
