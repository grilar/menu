<?php

namespace Grilar\Menu\Repositories\Eloquent;

use Grilar\Base\Enums\BaseStatusEnum;
use Grilar\Base\Models\BaseModel;
use Grilar\Menu\Models\Menu;
use Grilar\Menu\Repositories\Interfaces\MenuInterface;
use Grilar\Support\Repositories\Eloquent\RepositoriesAbstract;

class MenuRepository extends RepositoriesAbstract implements MenuInterface
{
    public function findBySlug(string $slug, bool $active, array $select = [], array $with = []): BaseModel|null
    {
        $data = $this->model->where('slug', $slug);

        if ($active) {
            $data = $data->where('status', BaseStatusEnum::PUBLISHED);
        }

        if (! empty($select)) {
            $data = $data->select($select);
        }

        if (! empty($with)) {
            $data = $data->with($with);
        }

        $data = $this->applyBeforeExecuteQuery($data, true)->first();

        $this->resetModel();

        return $data;
    }

    public function createSlug(string $name): string
    {
        return Menu::createSlug($name, null);
    }
}
