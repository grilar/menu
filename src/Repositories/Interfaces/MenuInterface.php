<?php

namespace Grilar\Menu\Repositories\Interfaces;

use Grilar\Base\Models\BaseModel;
use Grilar\Support\Repositories\Interfaces\RepositoryInterface;

interface MenuInterface extends RepositoryInterface
{
    public function findBySlug(string $slug, bool $active, array $select = [], array $with = []): BaseModel|null;

    public function createSlug(string $name): string;
}
