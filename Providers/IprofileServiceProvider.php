<?php

namespace Modules\Iprofile\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Iprofile\Events\Handlers\RegisterIprofileSidebar;
use Modules\Iprofile\Repositories\UserRepository;


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

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('userfields', array_dot(trans('iprofile::userfields')));
            $event->load('departments', array_dot(trans('iprofile::departments')));
            $event->load('addresses', array_dot(trans('iprofile::addresses')));
            // append translations



        });
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
            UserRepository::class,
            "Modules\\Iprofile\\Repositories\\Eloquent\\EloquentUserRepository"
        );
        $this->app->bind(
            'Modules\Iprofile\Repositories\UserFieldRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentUserFieldRepository(new \Modules\Iprofile\Entities\UserField());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iprofile\Repositories\Cache\CacheUserFieldDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iprofile\Repositories\DepartmentRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentDepartmentRepository(new \Modules\Iprofile\Entities\Department());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iprofile\Repositories\Cache\CacheDepartmentDecorator($repository);
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
