<?php

namespace Modules\Iprofile\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Iprofile\Events\Handlers\RegisterIprofileSidebar;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel as SentinelCartalyst;

use Modules\Iprofile\Repositories\ApiUserRepository;
use Modules\Iprofile\Repositories\Eloquent\EloquentApiUserRepository;
use Modules\Iprofile\Repositories\Cache\CacheApiUserDecorator;
use Modules\User\Entities\Sentinel\User;

use Modules\Iprofile\Repositories\ApiRoleRepository;
use Modules\Iprofile\Repositories\Eloquent\EloquentApiRoleRepository;
use Modules\Iprofile\Repositories\Cache\CacheApiRoleDecorator;

class IprofileServiceProvider extends ServiceProvider
{
  use CanPublishConfiguration;
  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->registerBindings();
    $this->app['events']->listen(BuildingSidebar::class, RegisterIprofileSidebar::class);
  }

  public function boot()
  {
    $this->publishConfig('iprofile', 'permissions');
    $this->publishConfig('iprofile', 'config');
    $this->publishConfig('iprofile', 'settings');

    $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return array();
  }

  private function registerBindings()
  {
    $this->app->bind(
      'Modules\Iprofile\Repositories\ProfileRepository',
      function () {
        $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentProfileRepository(new \Modules\Iprofile\Entities\Profile());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Iprofile\Repositories\Cache\CacheProfileDecorator($repository);
      }
    );

    $this->app->bind(
      'Modules\Iprofile\Repositories\AddressRepository',
      function () {
        $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentAddressRepository(new \Modules\Iprofile\Entities\Address());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Iprofile\Repositories\Cache\CacheAddressDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Iprofile\Repositories\DepartmentRepository',
      function () {
        $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentDepartmentRepository(new \Modules\Iprofile\Entities\Department());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Iprofile\Repositories\Cache\CacheDepartmentDecorator($repository);
      }
    );

    //Repository User Api
    $this->app->bind(ApiUserRepository::class, function () {
      $repository = new EloquentApiUserRepository(new User());

      if (!config('app.cache')) {
        return $repository;
      }

      return new CacheApiUserDecorator($repository);
    });

    //Repository User Api
    $this->app->bind(ApiRoleRepository::class,
      function () {
        $repository = new EloquentApiRoleRepository(SentinelCartalyst::getRoleRepository()->createModel());

        if (!config('app.cache')) {
          return $repository;
        }

        return new CacheApiRoleDecorator($repository);
      });
  }
}
