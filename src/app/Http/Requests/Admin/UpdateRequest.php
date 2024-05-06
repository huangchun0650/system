<?php

namespace YFDev\System\App\Http\Requests\Admin;

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
            'account' => [
                'sometimes',
                'string',
                // "regex:/^[a-z][a-z\d]{5,29}/",
                Rule::unique('admins', 'account')->ignore($this->route('admin')->id),
            ],
            'name' => [
                'sometimes',
                'string',
                Rule::unique('admins', 'name')->ignore($this->route('admin')->id),
            ],
            'email' => [
                'sometimes',
                'email',
            ],
            'password' => [
                'sometimes',
                'string',
                'min:6',
            ],
            'roles' => [
                'array',
            ],
            'roles.*' => [
                'sometimes',
                'integer',
                Rule::exists(config('permission.table_names.roles'), 'id'),
            ],
        ];
    }
}
