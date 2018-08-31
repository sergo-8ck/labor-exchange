<?php

namespace App\Providers;

use App\Entity\Vacancy;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    'App\Model' => 'App\Policies\ModelPolicy',
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();
    $this->registerPermissions();
    //
  }
  private function registerPermissions(): void
  {
    Gate::define('admin-panel', function (User $user) {
      return $user->isAdmin();
    });
    Gate::define('manage-pages', function (User $user) {
      return $user->isAdmin();
    });
    Gate::define('manage-users', function (User $user) {
      return $user->isAdmin();
    });
    Gate::define('manage-vacancies', function (User $user) {
      return $user->isAdmin();
    });

    Gate::define('show-vacancy', function (User $user, Vacancy $vacancy) {
      return $user->isAdmin() || $vacancy->user_id === $user->id;
    });

    Gate::define('manage-own-vacancy', function (User $user, Vacancy $vacancy) {
      return $vacancy->user_id === $user->id;
    });

  }
}
