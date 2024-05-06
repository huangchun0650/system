<?php

namespace YFDev\System\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    use HasFactory;

    protected $table = 'permissions';

    protected $guarded = [];

    public const FIELDS = [
        'name',
        'guard_name' => 'guardName',
    ];

    public function rule()
    {
        return Permission::whereIn('id', json_decode($this->permissions))->get();
    }
}
