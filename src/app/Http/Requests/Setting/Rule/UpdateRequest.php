<?php

namespace YFDev\System\App\Http\Requests\Setting\Rule;

use Illuminate\Validation\Rule;
use YFDev\System\App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'sometimes',
                'string',
                Rule::unique('rules', 'name')->ignore($this->route('rule')->id),
            ],
            'methodId' => [
                'sometimes',
                'integer',
                Rule::exists('methods', 'id'),
            ],
            'permissions' => 'array',
            'permissions.*' => [
                'sometimes',
                'integer',
                Rule::exists(config('permission.table_names.permissions'), 'id'),
            ],
        ];
    }
}
