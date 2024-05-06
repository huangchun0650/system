<?php

namespace YFDev\System\App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use YFDev\System\App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
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
                'required',
                'string',
                // "regex:/^[a-z][a-z\d]{5,29}/",
                Rule::unique('admins', 'account'),
            ],
            'name' => [
                'required',
                'string',
                Rule::unique('admins', 'name'),
            ],
            'email' => [
                'nullable',
                'email',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
            'roles' => [
                'array',
            ],
            'roles.*' => [
                'required',
                'integer',
                Rule::exists(config('permission.table_names.roles'), 'id'),
            ],
        ];
    }
}
