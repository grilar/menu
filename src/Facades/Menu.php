<?php

namespace Grilar\Menu\Facades;

use Grilar\Menu\Menu as BaseMenu;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool hasMenu(string $slug)
 * @method static array recursiveSaveMenu(array $menuNodes, string|int $menuId, string|int $parentId)
 * @method static \Grilar\Menu\Models\MenuNode getReferenceMenuNode(array $item, \Grilar\Menu\Models\MenuNode $menuNode)
 * @method static \Grilar\Menu\Menu addMenuLocation(string $location, string $description)
 * @method static array getMenuLocations()
 * @method static \Grilar\Menu\Menu removeMenuLocation(string $location)
 * @method static string renderMenuLocation(string $location, array $attributes = [])
 * @method static bool isLocationHasMenu(string $location)
 * @method static void load(bool $force = false)
 * @method static string|null generateMenu(array $args = [])
 * @method static void registerMenuOptions(string $model, string $name)
 * @method static string|null generateSelect(array $args = [])
 * @method static \Grilar\Menu\Menu addMenuOptionModel(string $model)
 * @method static array getMenuOptionModels()
 * @method static \Grilar\Menu\Menu setMenuOptionModels(array $models)
 * @method static \Grilar\Menu\Menu clearCacheMenuItems()
 *
 * @see \Grilar\Menu\Menu
 */
class Menu extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseMenu::class;
    }
}
