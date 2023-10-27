<?php

namespace Grilar\Menu\Http\Requests;

use Grilar\Support\Http\Requests\Request;

class MenuNodeRequest extends Request
{
    public function rules(): array
    {
        return [
            'data.menu_id' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'data.menu_id' => trans('packages/menu::menu.menu_id'),
        ];
    }
}
