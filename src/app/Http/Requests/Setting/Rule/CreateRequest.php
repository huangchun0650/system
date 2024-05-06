<?php

namespace YFDev\System\App\Http\Requests\Setting\Rule;

use Illuminate\Validation\Rule;
use YFDev\System\App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest
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
                'required',
                'string',
            ],
            'methodId' => [
                'required',
                'integer',
                Rule::exists('methods', 'id'),
            ],
            'permissions' => 'required|array',
            'permissions.*' => [
                'required',
                'integer',
                Rule::exists(config('permission.table_names.permissions'), 'id'),
            ],
        ];
    }
}
