<?php


namespace Modules\Iprofile\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Iprofile\Events\Handlers\RegisterFieldUser;
use Modules\Iprofile\Events\Handlers\UpdatedFieldUser;
use Modules\Iprofile\Events\ProfileWasCreated;
use Modules\Iprofile\Events\ProfileWasUpdated;
use Modules\User\Events\Handlers\SendRegistrationConfirmationEmail;
use Modules\User\Events\Handlers\SendResetCodeEmail;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProfileWasCreated::class => [
            RegisterFieldUser::class,
        ],
        ProfileWasUpdated::class => [
            UpdatedFieldUser::class,
        ],

    ];
}