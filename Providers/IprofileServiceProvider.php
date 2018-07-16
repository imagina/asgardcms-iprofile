<?php

namespace Modules\Iprofile\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Iprofile\Events\Handlers\RegisterIprofileSidebar;

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

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iprofile\Repositories\Cache\CacheProfileDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Iprofile\Repositories\AddressRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentAddressRepository(new \Modules\Iprofile\Entities\Address());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iprofile\Repositories\Cache\CacheAddressDecorator($repository);
            }
        );
// add bindings



    }
}
