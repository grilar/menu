<?php

namespace Grilar\Menu\Providers;

use Grilar\Base\Facades\DashboardMenu;
use Grilar\Base\Supports\ServiceProvider;
use Grilar\Base\Traits\LoadAndPublishDataTrait;
use Grilar\Menu\Models\Menu as MenuModel;
use Grilar\Menu\Models\MenuLocation;
use Grilar\Menu\Models\MenuNode;
use Grilar\Menu\Repositories\Eloquent\MenuLocationRepository;
use Grilar\Menu\Repositories\Eloquent\MenuNodeRepository;
use Grilar\Menu\Repositories\Eloquent\MenuRepository;
use Grilar\Menu\Repositories\Interfaces\MenuInterface;
use Grilar\Menu\Repositories\Interfaces\MenuLocationInterface;
use Grilar\Menu\Repositories\Interfaces\MenuNodeInterface;
use Grilar\Theme\Facades\AdminBar;
use Illuminate\Routing\Events\RouteMatched;

class MenuServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->setNamespace('packages/menu')
            ->loadHelpers();

        $this->app->bind(MenuInterface::class, function () {
            return new MenuRepository(new MenuModel());
        });

        $this->app->bind(MenuNodeInterface::class, function () {
            return new MenuNodeRepository(new MenuNode());
        });

        $this->app->bind(MenuLocationInterface::class, function () {
            return new MenuLocationRepository(new MenuLocation());
        });
    }

    public function boot(): void
    {
        $this
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadRoutes()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations()
            ->publishAssets();

        $this->app['events']->listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id' => 'cms-core-menu',
                'priority' => 2,
                'parent_id' => 'cms-core-appearance',
                'name' => 'packages/menu::menu.name',
                'icon' => null,
                'url' => route('menus.index'),
                'permissions' => ['menus.index'],
            ]);

            if (! defined('THEME_MODULE_SCREEN_NAME')) {
                DashboardMenu::registerItem([
                    'id' => 'cms-core-appearance',
                    'priority' => 996,
                    'parent_id' => null,
                    'name' => 'packages/theme::theme.appearance',
                    'icon' => 'fa fa-paint-brush',
                    'url' => '#',
                    'permissions' => [],
                ]);
            }

            if (function_exists('admin_bar')) {
                AdminBar::registerLink(
                    trans('packages/menu::menu.name'),
                    route('menus.index'),
                    'appearance',
                    'menus.index'
                );
            }
        });

        $this->app->register(EventServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
    }
}
