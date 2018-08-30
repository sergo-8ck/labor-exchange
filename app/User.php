<?php

namespace App;

use App\Entity\Vacancy;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;


/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 *
 */
class User extends Authenticatable
{
  use Notifiable;

  public const ROLE_USER = 'user';
  public const ROLE_ADMIN = 'admin';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password', 'role'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public static function register(string $name, string $email, string $password): self
  {
    return static::create([
      'name' => $name,
      'email' => $email,
      'password' => bcrypt($password),
      'verify_token' => Str::uuid(),
      'role' => self::ROLE_USER,
    ]);
  }

  public static function new($name, $email): self
  {
    return static::create([
      'name' => $name,
      'email' => $email,
      'password' => bcrypt(Str::random()),
      'role' => self::ROLE_USER,
      'status' => self::STATUS_ACTIVE,
    ]);
  }


  public static function rolesList(): array
  {
    return [
      self::ROLE_USER => 'User',
      self::ROLE_ADMIN => 'Admin',
    ];
  }

  public function changeRole($role): void
  {
    if (!array_key_exists($role, self::rolesList())) {
      throw new \InvalidArgumentException('Undefined role "' . $role . '"');
    }
    if ($this->role === $role) {
      throw new \DomainException('Role is already assigned.');
    }
    $this->update(['role' => $role]);
  }

  public function isAdmin(): bool
  {
    return $this->role === self::ROLE_ADMIN;
  }
  public function vacancies()
  {
    return $this->hasMany(Vacancy::class);
  }

}
