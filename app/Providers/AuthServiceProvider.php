<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Policies\AdminPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The model to policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    User::class => AdminPolicy::class
  ];

  /**
   * Register any authentication / authorization services.
   */
  public function boot(): void
  {
    Gate::define('create-gudang', [AdminPolicy::class, 'createGudang']);
    Gate::define('update-gudang', [AdminPolicy::class, 'updateGudang']);
    Gate::define('delete-gudang', [AdminPolicy::class, 'deleteGudang']);

    Gate::define('create-ukur', [AdminPolicy::class, 'createUkur']);
    Gate::define('update-ukur', [AdminPolicy::class, 'updateUkur']);
    Gate::define('delete-ukur', [AdminPolicy::class, 'deleteUkur']);

    Gate::define('read-gudang', [AdminPolicy::class, 'readGudang']);
    Gate::define('read-ukur', [AdminPolicy::class, 'readUkur']);
  }
}
