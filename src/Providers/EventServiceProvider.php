<?php

namespace Grilar\Menu\Providers;

use Grilar\Base\Events\DeletedContentEvent;
use Grilar\Menu\Listeners\DeleteMenuNodeListener;
use Grilar\Menu\Listeners\UpdateMenuNodeUrlListener;
use Grilar\Slug\Events\UpdatedSlugEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdatedSlugEvent::class => [
            UpdateMenuNodeUrlListener::class,
        ],
        DeletedContentEvent::class => [
            DeleteMenuNodeListener::class,
        ],
    ];
}
