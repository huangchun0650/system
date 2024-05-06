<?php

namespace YFDev\System\App\Http\Requests\Menu;

use Illuminate\Validation\Rule;
use YFDev\System\App\Http\Requests\BaseRequest;

class UpdateRulesRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'rules' => 'array',
            'rules.*' => [
                'sometimes',
                'integer',
                Rule::exists('rules', 'id'),
            ],
        ];
    }
}
