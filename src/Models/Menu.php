<?php

namespace Grilar\Menu\Models;

use Grilar\Base\Casts\SafeContent;
use Grilar\Base\Enums\BaseStatusEnum;
use Grilar\Base\Models\BaseModel;
use Grilar\Base\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static \Grilar\Base\Models\BaseQueryBuilder<static> query()
 */
class Menu extends BaseModel
{
    use HasSlug;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        static::deleted(function (self $model) {
            $model->menuNodes()->delete();
        });

        self::saving(function (self $model) {
            $model->slug = self::createSlug($model->slug, $model->getKey());
        });
    }

    public function menuNodes(): HasMany
    {
        return $this->hasMany(MenuNode::class, 'menu_id');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(MenuLocation::class, 'menu_id');
    }
}
