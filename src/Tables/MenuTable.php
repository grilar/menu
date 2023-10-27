<?php

namespace Grilar\Menu\Tables;

use Grilar\Base\Enums\BaseStatusEnum;
use Grilar\Menu\Models\Menu;
use Grilar\Table\Abstracts\TableAbstract;
use Grilar\Table\Actions\DeleteAction;
use Grilar\Table\Actions\EditAction;
use Grilar\Table\BulkActions\DeleteBulkAction;
use Grilar\Table\Columns\CreatedAtColumn;
use Grilar\Table\Columns\IdColumn;
use Grilar\Table\Columns\NameColumn;
use Grilar\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Validation\Rule;

class MenuTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Menu::class)
            ->addActions([
                EditAction::make()->route('menus.edit'),
                DeleteAction::make()->route('menus.destroy'),
            ]);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this
            ->getModel()
            ->query()
            ->select([
                'id',
                'name',
                'created_at',
                'status',
            ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make()->route('menus.edit'),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('menus.create'), 'menus.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('menus.destroy'),
        ];
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'customSelect',
                'choices' => BaseStatusEnum::labels(),
                'validate' => 'required|' . Rule::in(BaseStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }
}
