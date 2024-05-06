<?php

namespace YFDev\System\App\Http\Requests\Menu;

use Illuminate\Validation\Rule;
use YFDev\System\App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'sortOrder' => [
                'nullable',
                'integer',
            ],
            'name' => [
                'required',
                'string',
                Rule::unique('menus', 'name'),
            ],
            'code' => [
                'required',
                'string',
                Rule::unique('menus', 'code'),
            ],
            'parentId' => [
                'nullable',
                'integer',
                Rule::exists('menus', 'id'),
            ],
        ];
    }
}
