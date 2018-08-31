<?php

namespace App\Entity;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string $status
 *
 * @property User $user
 * @method Builder active()
 * @method Builder forUser(User $user)
 */
class Vacancy extends Model
{
  public const STATUS_MODERATION = 'moderation';
  public const STATUS_ACTIVE = 'active';

  protected $table = 'vacancy';

  protected $fillable = [
    'title', 'content', 'status'
  ];

  protected $casts = [
    'expires_at' => 'datetime',
  ];
  public static function statusesList(): array
  {
    return [
      self::STATUS_MODERATION => 'On Moderation',
      self::STATUS_ACTIVE => 'Active',
    ];
  }
  public function sendToModeration(): void
  {
    $this->update([
      'status' => self::STATUS_MODERATION,
    ]);
  }

  public function moderate(Carbon $date): void
  {
    if ($this->status !== self::STATUS_MODERATION) {
      throw new \DomainException('Vacancy is not sent to moderation.');
    }
    $this->update([
      'published_at' => $date,
      'status' => self::STATUS_ACTIVE,
    ]);
  }

  public function isOnModeration(): bool
  {
    return $this->status === self::STATUS_MODERATION;
  }

  public function isActive(): bool
  {
    return $this->status === self::STATUS_ACTIVE;
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function scopeForUser(Builder $query, User $user)
  {
    return $query->where('user_id', $user->id);
  }
}
