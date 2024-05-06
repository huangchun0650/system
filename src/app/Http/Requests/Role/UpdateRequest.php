<?php

namespace YFDev\System\App\Http\Requests\Role;

use Illuminate\Validation\Rule;
use YFDev\System\App\Exceptions\Request\NotAllowUpdateException;
use YFDev\System\App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules()
    {
        $role = $this->route('role');

        if ($role->name === config('permission.super_admin')) {
            throw new NotAllowUpdateException('The super admin role cannot be update');
        }

        return [
            'name' => [
                'sometimes',
                'string',
                Rule::unique('roles', 'name')->ignore($role->id),
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
