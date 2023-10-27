<?php

namespace Grilar\Menu\Providers;

use Grilar\Base\Supports\ServiceProvider;
use Grilar\Menu\Commands\ClearMenuCacheCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            ClearMenuCacheCommand::class,
        ]);
    }
}
